package sooth.similarity;

import java.util.ArrayList;

public class TokenString extends ArrayList<Token> {
    public static TokenString createFromString(String string)
    {
        TokenString tokenString = new TokenString();
        tokenString.ensureCapacity(string.length());
        for (int i = 0; i < string.length(); i++)
        {
            Token token = new Token(string.charAt(i));
            tokenString.add(token);
        }
        return tokenString;
    }
}