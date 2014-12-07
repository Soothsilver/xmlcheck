package sooth.similarity;

import sun.reflect.generics.reflectiveObjects.NotImplementedException;

import java.lang.reflect.Field;

// so far, this code is copied from wikipedia; rewrite later
public class LevenshteinDistanceTest {

    private static ThreadLocal<LevenshteinDistanceTest> instance = new ThreadLocal<LevenshteinDistanceTest>() {
        @Override
        protected LevenshteinDistanceTest initialValue() {
            return new LevenshteinDistanceTest();
        }
    };
    private int[] v0 = new int[10000];
    private int[] v1 = new int[10000];
    private Field field = null;
    public LevenshteinDistanceTest() {
        try {
            field = String.class.getDeclaredField("value");
            field.setAccessible(true);
        } catch (NoSuchFieldException ignored) {
           // Won't happen.
        }
    }
    public static LevenshteinDistanceTest getInstance() {
        return instance.get();
    }
    public int compare(String oldDocument, String newDocument)
    {
        // create two work vectors of integer distances
        int maxDistance = Math.max(oldDocument.length(), newDocument.length());
        if (v0.length < maxDistance + 1)
        {
            v0 = new int[maxDistance + 1];
        }
        if (v1.length < (maxDistance + 1))
        {
            v1 = new int[maxDistance + 1];
        }

        int[] vCopyFrom = v0;
        int[] vCopyTo = v1;

        int newDocumentLength = newDocument.length();
        int oldDocumentLength = oldDocument.length();

        try {
            final char[] oldCharArray = (char[]) field.get(oldDocument);
            final char[] newCharArray = (char[]) field.get(newDocument);

            // initialize v0 (the previous row of distances)
            // this row is A[0][i]: edit distance for an empty s
            // the distance is just the number of characters to delete from t
            for (int i = 0; i <= newDocumentLength; i++) {
                vCopyFrom[i] = i;
            }

            for (int i = 0; i < oldDocumentLength; i++)
            {
                // calculate v1 (current row distances) from the previous row v0

                // first element of v1 is A[i+1][0]
                //   edit distance is delete (i+1) chars from s to match empty t
                vCopyTo[0] = i + 1;

                // use formula to fill in the rest of the row
                for (int j = 0; j < newDocumentLength; j++)
                {
                    int cost = (oldCharArray[i] == newCharArray[j]) ? 0 : 1;
                    vCopyTo[j + 1] = Math.min(Math.min(vCopyTo[j] + 1, vCopyFrom[j + 1] + 1), vCopyFrom[j] + cost);
                }

                int[] vIntermediary = vCopyFrom;
                vCopyFrom = vCopyTo;
                vCopyTo = vIntermediary;
            }
            return vCopyFrom[newDocumentLength];
        } catch (IllegalAccessException ignored) {
            // Won't happen.
            // TODO throw different exception typ here
            throw new NotImplementedException();
        }
    }
}
