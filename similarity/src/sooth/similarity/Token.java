package sooth.similarity;

public class Token {
    private char character;
    public boolean marked = false;

    public boolean isSameTokenAs(Token token)
    {
        return this.character == token.character;
    }

    public Token(char c)
    {
        character = c;
    }

    public char getCharacter() {
        return character;
    }
}
