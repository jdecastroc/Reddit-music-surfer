/**
 * Main process of the Reddit Music Surfer
 * 
 * @author: hoppy93
 * @version: 24/01/2016/A
 * @see <a href = "https://github.com/jdecastroc/Reddit-music-surfer" /> Github
 *      repository </a>
 */

package crawlers;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.util.regex.*;
import java.io.IOException;
import java.util.Collections;
import java.util.Vector;

import com.google.gson.*;

public class Surfer {

	/**
	 * Allow to compare a specified string and a found
	 * 
	 * @author hoppy93
	 * @param pattern
	 *            ->Specifies the string you want to compare with the matcher
	 * @param matcher
	 *            ->Specifies the string you found while parsing
	 */
	public static boolean match(String pattern, String matcher) {
		Pattern h = Pattern.compile(pattern);
		Matcher m = h.matcher(matcher);
		return m.find();
	}

	/**
	 * Crawler. Surf /r/Music/wiki/musicsubreddits to gather most of the music
	 * reddits. This is going to be the list of Reddits to choose.
	 * 
	 * @author hoppy93
	 */
	public static String showReddits() throws IOException {

		Vector<RedditList> listaFinal = new Vector<RedditList>();

		Gson gson = new GsonBuilder().disableHtmlEscaping().setPrettyPrinting().create();
		Document doc = Jsoup.connect("https://www.reddit.com/r/Music/wiki/musicsubreddits")
				.userAgent("web:com.ReddMusic.surfReddit:v1.3 ALPHA by /u/hoppy93").timeout(0).get();
		Elements links = doc.select("h2, li, a");
		// result = input.split("-")[0];
		String title = "", hrefText = "";
		for (Element element : links) {
			if (element.tagName().equals("h2")) {
				title = element.select("h2").text();

				// Debug mode
				// System.out.println("Title: " + element.select("h2").text());
			}
			if (match("/r/", element.text()) && element.tagName().equals("li")) {
				hrefText = element.select("a").text();
				if (listaFinal.isEmpty() || listaFinal.lastElement().getListName() != title) {
					listaFinal.addElement(new RedditList());
					listaFinal.lastElement().setListName(title);
				} else {
					if (hrefText != "/r/music") {
						hrefText = hrefText.split(" ")[0];
						listaFinal.lastElement().addReddit(new Reddit(hrefText, "https://www.reddit.com" + hrefText));
					}
				}
			}
		}
		String jsonListaReddits = gson.toJson(listaFinal);
		return jsonListaReddits;
	}

	public static String nextSong(String web, String actualSong, String prevRedditSong) throws IOException {
		String next = "";

		return next;
	}

	public static String prevSong(String web, String actualSong) throws IOException {
		String next = "";

		return next;
	}

	/**
	 * Crawler. Surf the specified reddits reading the different music links
	 * 
	 * @author hoppy93
	 * @param web
	 *            ->link of the website to crawl
	 * @param listaLinks
	 *            ->list of the gathered links
	 * @param pages
	 *            ->following pages to crawl
	 */
	public static Vector<String> surfReddit(String web, Vector<String> listaLinks, int pages) throws IOException {

		pages--; // Main var to exit recursion
		Document doc = Jsoup.connect(web).userAgent("web:com.ReddMusic.surfReddit:v1 by /u/hoppy93").timeout(0).get();
		Elements links = doc.select("a[href]");
		String output = "";

		for (Element src : links) {
			if (src.tagName().equals("a")) {
				String linkHref = src.attr("abs:href");

				// Next link search pattern
				if (match("nextprev", src.parent().className().trim())) {
					// System.out.println("Output exit: "+ pages + " -> " +
					// src.attr("abs:href"));
					output = src.attr("abs:href");
				}
				// Youtube links search pattern
				if (match("youtu", linkHref) && !match("reddit", linkHref)) {
					if (!listaLinks.contains(linkHref))
						listaLinks.addElement(linkHref);
				}
				// Soundcloud links search pattern
				// TODO FRONTEND doesn't accept soundcloud links yet
				// if (match("soundcl",linkHref) && !match("reddit",linkHref)){
				// if (!listaLinks.contains(linkHref))
				// listaLinks.addElement(linkHref);
				// }
			}
		}
		if (pages == 0)
			return listaLinks;
		else {
			try {
				// Put down it to 500 to speed-up the operations, neccesary to
				// make another request for the following pages
				Thread.sleep(500);
			} catch (InterruptedException e) {
			}
			return surfReddit(output, listaLinks, pages--);
		}
	}

	/**
	 * Crawler. Surf the specified reddits reading the different music links
	 * 
	 * @author hoppy93
	 * @param redditList
	 *            -> List of reddits to crawl
	 * @param shuffle
	 *            -> boolean, shuffle or not the final list
	 * @param pages
	 *            -> number of pages to crawl of each reddit
	 */

	public static String surfRedditList(Vector<Reddit> redditList, boolean shuffle, int pages) throws IOException {

		Vector<String> listaLinksFinal = new Vector<String>();
		Gson gson = new GsonBuilder().disableHtmlEscaping().setPrettyPrinting().create();

		for (Reddit i : redditList) {
			surfReddit(i.getUrlReddit(), i.getList(), pages);

			for (String p : i.getList()) {
				listaLinksFinal.add(p);
			}
		}
		// Debug mode
		// This prints in JSON all the listaReddit information (each Reddit
		// name, URL and links)
		// String jsonListaReddit = gson.toJson(listaReddit);
		// System.out.println("Reddit gathered information per reddit= " +
		// jsonListaReddit);

		if (shuffle == false) {
			String jsonListaFinal = gson.toJson(listaLinksFinal);
			return jsonListaFinal;
		} else {
			Collections.shuffle(listaLinksFinal);
			String jsonListaFinal = gson.toJson(listaLinksFinal);
			return jsonListaFinal;
		}
	}

	// Debug mode
//	public static void main(String[] args) throws IOException {
//
//		Vector<Reddit> listaReddit = new Vector<Reddit>();
//		// listaReddit.addElement(new
//		// Reddit("Japanesemusic","https://www.reddit.com/r/japanesemusic/"));
//		// listaReddit.addElement(new
//		// Reddit("Electronicmusic","https://www.reddit.com/r/ElectronicMusic"));
//
//		// String listaLinks = surfRedditList(listaReddit,true,3);
//		// System.out.println("Links: " + listaLinks);
//
//		System.out.println("");
//		String listaRedditsFinal = showReddits();
//		System.out.println("Reddits available: " + listaRedditsFinal);
//	}
}
