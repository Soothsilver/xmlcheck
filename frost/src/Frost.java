import sooth.similarity.LevenshteinDistanceIgnoreWhitespaceTest;
import sooth.similarity.LevenshteinDistanceTest;
import sooth.similarity.TextIdentityTest;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;

public class Frost {
    public static void main(String[] args) throws IOException {
        String one = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\frost\\testcases\\one.xml")));
        String two = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\frost\\testcases\\two.xml")));

        System.out.println("Text Identity Test, one vs. one: " + (TextIdentityTest.compare(one, one) ? "IDENTICAL" : "DIFFERENT"));
        System.out.println("Text Identity Test, one vs. two: " + (TextIdentityTest.compare(one, two) ? "IDENTICAL" : "DIFFERENT"));
        System.out.println("Levenshtein Distance Test, one vs. one: " + (LevenshteinDistanceTest.compare(one, one)));
        System.out.println("Levenshtein Distance Test, one vs. two: " + (LevenshteinDistanceTest.compare(one, two)));
        System.out.println("Levenshtein Distance Test, No Whitespace Variant, one vs. one: " + (LevenshteinDistanceIgnoreWhitespaceTest.compare(one, one)));
        System.out.println("Levenshtein Distance Test, No Whitespace Variant, one vs. two: " + (LevenshteinDistanceIgnoreWhitespaceTest.compare(one, two)));
    }
}
