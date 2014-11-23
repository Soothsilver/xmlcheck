package sooth.similarity;

import java.util.ArrayList;
import java.util.List;

public class GreedyStringTilingAlgorithm {
    private static int minimumMatchLength = 2;
    private static class Match
    {
        public int PatternStart;
        public int DocumentStart;
        public int Length;
        public Match(int startPattern, int startDocument, int length) {
            PatternStart = startPattern;
            DocumentStart = startDocument;
            Length = length;
        }
    }
    public static int basicCompare(TokenString one, TokenString two)
    {
        if (one.size() == 0 || two.size() == 0)
        {
            return Math.max(one.size(), two.size()); // degenerate case
        }
        int lengthOfTokensTiled = 0;
        TokenString pattern = one;
        TokenString document = two;
        if (one.size() > two.size())
        {
            pattern = two;
            document = one;
        }
        int firstUnmarkedPatternToken = 0; // TODO calculate these
        int firstUnmarkedDocumentToken = 0;
        List<Match> matches = new ArrayList<>();
        List<Match> tilesFound = new ArrayList<>(); // list of tiles for debugging purposes
        int maxmatch = minimumMatchLength;
        do {
            maxmatch = minimumMatchLength;
            matches.clear();
            // Phase 1: Search
            for (int i = firstUnmarkedPatternToken; i < pattern.size(); i++) {
                for (int j = firstUnmarkedDocumentToken; j < document.size(); j++) {
                    int k = 0;
                    while (true)
                    {
                        if (i + k == pattern.size() || j + k == document.size()) {
                            break;
                        }
                        Token patternToken = pattern.get(i + k);
                        Token documentToken = document.get(j + k);
                        if (!patternToken.isSameTokenAs(documentToken)) { break; }
                        if (patternToken.marked) { break; }
                        if (documentToken.marked) { break; }
                        k++;
                    }
                    if (k == maxmatch)
                    {
                        matches.add(new Match(i, j, k));
                    }
                    else if (k > maxmatch)
                    {
                        matches.clear();
                        matches.add(new Match(i, j, k));
                        maxmatch = j;
                    }

                }
            }
            // Phase 2: Marking tiles
            for(Match match : matches) {
                // Occlusion test
                if (pattern.get(match.PatternStart).marked) { continue; }
                if (pattern.get(match.PatternStart + match.Length - 1).marked) { continue; }
                if (document.get(match.DocumentStart).marked) { continue; }
                if (document.get(match.DocumentStart + match.Length - 1).marked) { continue; }
                // Move the first unmarked thing to the right
                if (match.PatternStart == firstUnmarkedPatternToken) firstUnmarkedPatternToken = match.PatternStart + match.Length;
                if (match.DocumentStart == firstUnmarkedDocumentToken) firstUnmarkedDocumentToken = match.DocumentStart + match.Length;
                // Mark the tile
                for (int j = 0; j < match.Length; j++) {
                    pattern.get(match.PatternStart + j).marked = true;
                    document.get(match.DocumentStart + j).marked = true;
                }

                lengthOfTokensTiled += match.Length;
                tilesFound.add(match);
                System.out.println("Match found (pattern " + match.PatternStart + "-" + (match.PatternStart + match.Length - 1) + ", '" + debugDisplayMatch(pattern, match.PatternStart, match.Length) + "')");
            }
        } while (maxmatch > minimumMatchLength);
        return lengthOfTokensTiled;
    }

    private static String debugDisplayMatch(TokenString pattern, int start, int length) {
        StringBuilder stringBuilder = new StringBuilder(length);
        for (int i = start; i < start + length; i++) {
            stringBuilder.append(pattern.get(i).getCharacter());
        }
        return stringBuilder.toString();
    }
}
