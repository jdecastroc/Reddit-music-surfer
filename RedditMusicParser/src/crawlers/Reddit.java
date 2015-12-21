package crawlers;
import java.util.Vector;

public class Reddit {
	
	private String name;
	private String url;
	private Vector<String> listaLinks;

	public Reddit(String name, String url){
		this.name = name;
		this.url = url;
		this.listaLinks = new Vector<String>();
	}
	
	public String getUrlReddit(){
		return this.url;
	}
	
	public String getNameReddit(){
		return this.name;
	}
	
	public Vector<String> getList(){
		return this.listaLinks;
	}
	
	public boolean addLink(String url){
		this.listaLinks.addElement(url);
		return true;
	}	
}
