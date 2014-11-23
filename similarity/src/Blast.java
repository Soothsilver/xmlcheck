import sooth.similarity.TokenString;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;

public class Blast {
    public static void main(String[] args) throws IOException {

        TokenString tokenString = TokenString.createFromString("ABCD");

        String one = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\similarity\\testcases\\one.xml")));
        String two = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\similarity\\testcases\\two.xml")));

        System.out.println("SIMILARITY VIA GREEDY-STRING-TILING: " + sooth.similarity.GreedyStringTilingAlgorithm.basicCompare(TokenString.createFromString(one), TokenString.createFromString(two)));
    }
}
