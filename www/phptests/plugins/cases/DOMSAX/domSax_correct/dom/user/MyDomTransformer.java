package user;

import org.w3c.dom.Attr;
import org.w3c.dom.Document;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;

public class MyDomTransformer {

	public void transform (Document xmlDocument) {
		Node koren = xmlDocument.getElementsByTagName("netDB").item(0);
		NodeList adresy = xmlDocument.getElementsByTagName("address");
		int i,j;
		for (i=0;i<adresy.getLength();++i)
		{
			//Node nodeCopy = adresy.item(i).cloneNode(true);
			Node nodeCopy = xmlDocument.createElement("address-data");
			NodeList children = adresy.item(i).getChildNodes();
			for (j=0;j<children.getLength();++j)
			{
				 nodeCopy.appendChild(children.item(j).cloneNode(true));
			}
			String addressId = "address_".concat(Integer.toString(i));

			Attr newId = xmlDocument.createAttribute("id");
			newId.setValue(addressId);
			nodeCopy.getAttributes().setNamedItem(newId);

			Node nodeRef = xmlDocument.createElement("address-ref");
			Attr idRef = xmlDocument.createAttribute("ref");
			idRef.setValue(addressId);
			nodeRef.getAttributes().setNamedItem(idRef);

			Node next = adresy.item(i).getNextSibling();
			Node parent = adresy.item(i).getParentNode();
			parent.insertBefore(nodeRef, next);

		  koren.appendChild(nodeCopy);
		}

		for (i=0;i<xmlDocument.getElementsByTagName("address").getLength();++i)
		{
			Node old = xmlDocument.getElementsByTagName("address").item(i);
			old.getParentNode().removeChild(old);
			--i;
		}
	}
}