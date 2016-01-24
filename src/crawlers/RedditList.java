package crawlers;

import java.util.Vector;

public class RedditList {
	String name;
	Vector<Reddit> redditList;

	public RedditList() {
		this.name = "";
		this.redditList = new Vector<Reddit>();
	}

	public void setListName(String name) {
		this.name = name;
	}

	public String getListName() {
		return this.name;
	}

	public Vector<Reddit> getList() {
		return this.redditList;
	}

	public boolean addReddit(Reddit reddit) {
		this.redditList.addElement(reddit);
		return true;
	}
}
