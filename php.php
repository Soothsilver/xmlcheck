<?php
$a = "AAA";
$b = "BBB";
$time = microtime(true);
for ($i = 0; $i < 100000000; $i++)
{
    if ($a . $b !== "AAABBB")
    {
        echo "ERROR<br>";
    }
}
echo "OK<br>";
echo "Time taken: " + (microtime(true) - $time) * 1000 + " milliseconds<BR>";
/*import java.util.Objects;

public class Frost {
    public static void main(String[] args)
    {
        String a = "AAA";
        String b = "BBB";
        long time = System.nanoTime();
        for (int i = 0; i < 100000000; i++)
        {
            if (!Objects.equals(a + b, "AAABBB"))
            {
                System.out.println("ERROR");
            }
        }
        System.out.println("OK");
        System.out.println("Time taken: " + (System.nanoTime() - time)/1000000 + " milliseconds");
    }
}
*/