package sooth.scripts;

import sooth.Logging;
import sooth.Configuration;
import sooth.connection.InsertSimilaritiesBatch;
import sooth.objects.Similarity;
import sooth.objects.Submission;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Logger;

public class SimilarityCheckingBatch {
    private Logger logger = Logging.getLogger(SimilarityCheckingBatch.class.getName());
    private class SimilarityCommand {
        private Submission oldSubmission;
        private Submission newSubmission;
        public SimilarityCommand(Submission oldSubmission, Submission newSubmission) {
            this.oldSubmission = oldSubmission;
            this.newSubmission = newSubmission;
        }
    }

    private ArrayList<SimilarityCommand> commands;

    public SimilarityCheckingBatch(int capacity) {
        commands = new ArrayList<>(capacity);
    }

    public void addComparisonOfOneToMany(Submission newSubmission, ArrayList<Submission> submissions, int from, int upToExclusive) {
        for (int i = from; i < upToExclusive; i++) {
            if (submissions.get(i).getUserId() == newSubmission.getUserId())
            {
                // These submissions were uploaded by the same user.
                if (Configuration.ignoringSelfPlagiarism())
                {
                    continue;
                }
            }
            commands.add(new SimilarityCommand(submissions.get(i), newSubmission));
        }
    }

    public int size() {
        return commands.size();
    }

    public Iterable<Similarity> execute() {
        int coreCount = Runtime.getRuntime().availableProcessors(); // TODO when multithreading disabled, this should probably be 1.
        int size = commands.size();
        int workload = size / coreCount;
        int at = 0;
        logger.info("Forking...");
        SimilarityInsertionQueue queue = new SimilarityInsertionQueue(size);
        ArrayList<Thread> threads = new ArrayList<>();
        logger.info("Queue made.");
        for (int threadIndex = 0; threadIndex < coreCount -1; threadIndex++) {
            Runner runner = new Runner(threadIndex+1, commands, at, at+ workload, queue);
            Thread thread = new Thread(runner);
            thread.start();
            threads.add(thread);
            logger.info("Thread " + (threadIndex+1) + " started.");
            at += workload;
        }
        logger.info("Main thread started.");
        Runner runnerFinal = new Runner(coreCount, commands, at, size, queue);
        runnerFinal.run();

        logger.info("Collecting threads...");
        logger.info("Main thread ended.");
        for(Thread t : threads) {
            try {
                t.join();
            } catch (InterruptedException ignored) {
                // Won't happen.
            }
            logger.info("A thread joined.");
        }

        logger.info("Executed.");
        return queue;
    }
    private class SimilarityInsertionQueue extends java.util.ArrayList<Similarity> {
        private int count = 0;
        public SimilarityInsertionQueue(int capacity) {
            super(InsertSimilaritiesBatch.batchSize);
        }

        @Override
        public synchronized boolean add(Similarity similarity) {
            count++;
            if (count == InsertSimilaritiesBatch.batchSize) {
                InsertSimilaritiesBatch batch = new InsertSimilaritiesBatch();
                for (int i = 0; i < count-1; i++) {
                    batch.add(this.get(i));
                }
                count = 1;
                batch.execute();
                logger.info("Batch executed.");
                this.clear();
            }
            return super.add(similarity);
        }
    }
    private class Runner implements Runnable {
        private List<SimilarityCommand> commands;
        private int from;
        private int upToExclusive;
        private SimilarityInsertionQueue queue;
        private int threadIndex;

        public Runner(int threadIndex, List<SimilarityCommand> commands, int from, int upToExclusive, SimilarityInsertionQueue queue) {
            this.threadIndex = threadIndex;
            this.commands = commands;
            this.from = from;
            this.upToExclusive = upToExclusive;
            this.queue = queue;
        }

        @Override
        public void run() {
            int count = upToExclusive - from;
            int k = 1;
            for (int i = from; i < upToExclusive; i++) {
                Similarity similarity = Operations.compare(commands.get(i).oldSubmission, commands.get(i).newSubmission);
                if (similarity.isSuspicious() || similarity.getScore() >= Configuration.levenshteinMasterThreshold) {
                    queue.add(similarity);
                }
                if (i == from + count*k/10)
                {
                    System.gc();
                    logger.info("Thread " +  threadIndex + " - Percent done: " + (k*10 + " in time " + new Date()));
                    k++;
                }
            }
        }
    }
}
