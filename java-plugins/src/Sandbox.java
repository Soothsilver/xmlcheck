import name.hon2a.asmp.domsax.Main;

/**
 * This class serves no purpose.
 * It is used strictly for debugging purposes if a developer wants to quickly try to run a similarity module function.
 */
public class Sandbox {
    /**
     * The developer may test stuff here.
     * @param args Command-line arguments.
     */
    public static void main(String[] args)
    {
        Main domSax = new Main();
        System.out.println(
                domSax.run(
                        new String[] {
                                "C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\phptests\\plugins\\cases\\DOMSAX\\domSax_correct.zip"
                        } ));

    }
}

