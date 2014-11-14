package user;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

public class MySaxHandler extends DefaultHandler {

    int maxChars[];
    int elementCount[];
    int avgChars[];
    boolean openElements[];
    boolean pureText[];
    int currentChars[];
    String elements[];

	@Override
    public void startDocument() throws SAXException {

        maxChars = new int[50];
        elementCount = new int[50];
        avgChars = new int[50];
        openElements = new boolean[50];
        pureText = new boolean[50];
        currentChars = new int[50];
        elements = new String[50];
        for (int i=0;i<50;++i)
        {
            maxChars[i] = 0;
            avgChars[i] = 0;
            openElements[i] = false;
            pureText[i] = true;
            currentChars[i] = 0;
            elements[i] = "";
        }

    }

	@Override
    public void endDocument() throws SAXException {

        System.out.print("\nCharacter maxima and averages for pure-text elements:\n\n");
        for (int i=0;i<elements.length;++i)
        {
            if (elements[i].equals("")) break;
            else if (pureText[i])
            {
                System.out.print(elements[i].concat(" (").concat(Integer.toString(elementCount[i])).concat(" occurences) : ").concat(Integer.toString(maxChars[i]).concat(" max., ").concat(Integer.toString(avgChars[i])).concat(" average\n")));

            }
        }
        System.out.print("\nCharacter maxima and averages for other elements:\n\n");
        for (int i=0;i<elements.length;++i)
        {
            if (elements[i].equals("")) break;
            else if (!pureText[i])
            {
                System.out.print(elements[i].concat(" (").concat(Integer.toString(elementCount[i])).concat(" occurences) : ").concat(Integer.toString(maxChars[i]).concat(" max., ").concat(Integer.toString(avgChars[i])).concat(" average\n")));

            }
        }

    }

	@Override
    public void startElement(String uri, String localName, String qName, Attributes atts) throws SAXException {

        boolean firstFind = true;
        int elementIndex = 0, newIndex = 0;
        for (int i=0;i<elements.length;++i)
        {
            if (elements[i].equals(""))
            {
                newIndex = i;
                break;
            }
            else if (elements[i].equals(localName))
            {
                firstFind = false;
                elementIndex = i;
            }
            else if (openElements[i])
            {
                pureText[i] = false;
            }
        }
        if (firstFind)
        {
            elements[newIndex] = localName;
            elementIndex = newIndex;
        }

        openElements[elementIndex] = true;
        currentChars[elementIndex] = 0;
    }

	@Override
	public void endElement(String uri, String localName, String qName) throws SAXException {

        boolean firstFind = true;
        int elementIndex = 0, newIndex = 0;
        for (int i=0;i<elements.length;++i)
        {
            if (elements[i].equals(""))
            {
                newIndex = i;
                break;
            }
            if (elements[i].equals(localName))
            {
                firstFind = false;
                elementIndex = i;
            }
        }
        if (!firstFind)
        {
            openElements[elementIndex] = false;
            if (maxChars[elementIndex] < currentChars[elementIndex]) maxChars[elementIndex] = currentChars[elementIndex];
            avgChars[elementIndex] = (avgChars[elementIndex] * elementCount[elementIndex] + currentChars[elementIndex]) / ++elementCount[elementIndex];
        }

    }

	@Override
    public void characters(char[] ch, int start, int length) throws SAXException {

        for (int i=0;i<elements.length;++i)
        {
            if (elements[i].equals("")) break;
            else if (openElements[i])
            {
                currentChars[i] += length;
            }
        }

    }

}

