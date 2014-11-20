import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;

public class Frost {
    public static void main(String[] args) throws IOException {
        String one = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\frost\\testcases\\one.xml")));
        String two = new String(Files.readAllBytes(Paths.get("C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\frost\\testcases\\two.xml")));
        sooth.similarity.TextIdentityTest textIdentityTest = new sooth.similarity.TextIdentityTest();
        System.out.println("Text Identity Test, one vs. one: " + textIdentityTest.compare(one, one).getDetails());
        System.out.println("Text Identity Test, one vs. two: " + textIdentityTest.compare(one, two).getDetails());
    }
}
