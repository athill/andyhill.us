import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Dimension;
import java.lang.String;
import java.lang.Integer;
import java.util.StringTokenizer;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseEvent;

/**
 *
 *@author = <a href="mailto:athill@ariel.ucs.indiana.edu">Andy Hill</a>
 *@param YOURTEXT text used to scroll. Use '\\' to delimit separate items.
 * 
 */

public class Scroll extends Applet implements Runnable, MouseMotionListener {
  private Graphics g;
  public Graphics bufferGraphics;
  private int maxWidth;
  private final int TEXT_HEIGHT = 13;
  private Thread kicker;
  private Image offscreen;
  private Dimension dim;
  private int oldY, newY;
  private boolean moving;
  String line;
  private int x, y, height;
  public void init() {
    setBackground(Color.white);
    dim = getSize();
    x = dim.width;
    y = dim.height;
    maxWidth = x/6;
    resize(x , y);
    height = y;
    offscreen = createImage(dim.width, dim.height);
    bufferGraphics = offscreen.getGraphics();
    line = getParameter("YOURTEXT");
    addMouseMotionListener(this);
  }
  public void paint(Graphics g) {
    g.drawImage(offscreen,0,0,this);

  }
  public void update(Graphics g) {
    bufferGraphics.clearRect(0,0,dim.width, dim.height);
    int s = 0;
    StringTokenizer lines = new StringTokenizer(line, "\\");
    int numLines = lines.countTokens();
    for (int j = 1; j <= numLines; j++) {
      String phrase = lines.nextToken();
      while (phrase.length() > maxWidth) {        //wrap text around
	int i;
	for (i=maxWidth; phrase.charAt(i) != ' '; i--){}
	i++;
	String temp = phrase.substring(0, i);
	bufferGraphics.drawString(temp, 5, y + s);
	s += TEXT_HEIGHT;
	phrase = phrase.substring(i);
      }
      bufferGraphics.drawString(phrase, 5, y + s);
      s += TEXT_HEIGHT * 2;
      bufferGraphics.drawString("******************************************************", 
				5, y + s);
      s += TEXT_HEIGHT;
    }
    paint(g);
  }
//Start thread
  public void start() {
    if(kicker==null) {
      kicker = new Thread(this);
      kicker.start();
    }
  }

//Terminate thread
  public void stop() {
    kicker.interrupt();
    kicker = null;
  }

//Main loop
  public void run() {
    boolean finished = false;
    StringTokenizer lines = new StringTokenizer(line, "\\");
    int numLines = lines.countTokens();
    int offset = ((line.length() - (2 * numLines)) / maxWidth) * TEXT_HEIGHT 
	+ 3 * numLines * TEXT_HEIGHT;
    while (!finished) {
      if (y > (0 - offset)) {       //Wrap scrolling around
	y--;
      }
      else {
	y = height;
      }
      this.repaint();
      try {				//pause for 100ms
	Thread.sleep(100);
      }
      catch(InterruptedException e) { //stop if interrupted
	finished = true;
	System.out.println(e);
      }
    }
  }
  public void mouseMoved(MouseEvent e) {
    moving=false;
  }
  public void mouseDragged(MouseEvent e) {
    newY = e.getY();
    if (moving) {
      y += newY - oldY;
    }
    moving = true;
    oldY = newY;
  }
}

