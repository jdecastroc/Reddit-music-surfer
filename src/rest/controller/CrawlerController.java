/**
 * 
 */
package rest.controller;

import java.io.IOException;
import java.util.Vector;

import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.RestController;

/**
 * @author hoppy93
 * 
 * http://localhost:8080/playlist?redditList=japanesemusic,electronicmusic&mode=0&random=false
 */
@RestController
public class CrawlerController {

	@RequestMapping(value = "/playlist", method = RequestMethod.GET, produces="application/json")
	@ResponseStatus(HttpStatus.OK)
    public @ResponseBody String playReddit(@RequestParam(value="redditList") Vector<String> redditListRawl,
							   @RequestParam(value="mode") int mode,
							   @RequestParam(value="random") Boolean random) throws IOException {
		
		Vector<crawlers.Reddit> redditList = new Vector<crawlers.Reddit>();
		String listaLinks = "";

		for(String a : redditListRawl){
			redditList.addElement(new crawlers.Reddit(a,"https://www.reddit.com/r/" + a));
		}
		
		switch(mode){
		case 0: listaLinks = crawlers.Surfer.surfRedditList(redditList,random,2); break; //Recientes (2 paginas)
		case 1: listaLinks = crawlers.Surfer.surfRedditList(redditList,random,5); break; //Sin importancia (5 paginas)
		case 2: listaLinks = crawlers.Surfer.surfRedditList(redditList,random,10); break; //Muchas canciones (10 pag)
		default: listaLinks = crawlers.Surfer.surfRedditList(redditList,random,2); break;
		}

        return listaLinks;
    }
	
	@RequestMapping(value = "/redditList", method = RequestMethod.GET, produces="application/json")
	@ResponseStatus(HttpStatus.OK)
	public @ResponseBody String redditList() throws IOException{
		String listaRedditsFinal = crawlers.Surfer.showReddits();
		return listaRedditsFinal;
	}
	
	
	
}
