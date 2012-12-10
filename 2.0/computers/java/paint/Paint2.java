import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.*;
import java.awt.Dimension;
import java.awt.event.MouseMotionListener;
import java.awt.event.*;
import java.awt.Font;
/**
 *
 *@author = <a href="mailto:athill@ariel.ucs.indiana.edu">Andy Hill</a>
 *Supplies a drawing surface and boxes to choose stroke width and stroke
 *color.
 *
 */

public class Paint extends Applet {

  public Pad pad;
  public Panel controls, sizeControls;
  Graphics g;
  public void init() {
    setBackground(Color.black);
    setSize(400, 400);
    pad = new Pad();
    pad.setSize(375, 300);
    pad.setBackground(Color.white);
    add(pad);
    controls = new Panel();
    controls.setSize(300, 100);
    controls.setLayout(new FlowLayout(FlowLayout.LEFT));
    controls.setBackground(Color.gray);
    sizeControls = new Panel();
    sizeControls.setSize(300, 100);
    sizeControls.setLayout(new FlowLayout(FlowLayout.LEFT));
    sizeControls.setBackground(Color.gray);
    Option red = new Option(pad, Color.red);
    controls.add(red);
    Option white = new Option(pad, Color.white);
    controls.add(white);
    Option blue = new Option(pad, Color.blue);
    controls.add(blue);
    Option yellow = new Option(pad, Color.yellow);
    controls.add(yellow);
    Option black = new Option(pad, Color.black);
    controls.add(black);
    Option cyan = new Option(pad, Color.cyan);
    controls.add(cyan);
    Option darkGray = new Option(pad, Color.darkGray);
    controls.add(darkGray);
    Option gray = new Option(pad, Color.gray);
    controls.add(gray);
    Option green = new Option(pad, Color.green);
    controls.add(green);
    Option lightGray = new Option(pad, Color.lightGray);
    controls.add(lightGray);
    Option magenta = new Option(pad, Color.magenta);
    controls.add(magenta);
    Option orange = new Option(pad, Color.orange);
    controls.add(orange);
    Option pink = new Option(pad, Color.pink);
    controls.add(pink);
    Option two = new Option(pad, 2);
    sizeControls.add(two);
    Option four = new Option(pad, 4);
    sizeControls.add(four);
    Option six = new Option(pad, 6);
    sizeControls.add(six);
    Option eight = new Option(pad, 8);
    sizeControls.add(eight);
    Option ten = new Option(pad, 10);
    sizeControls.add(ten);
    Option twelve = new Option(pad, 12);
    sizeControls.add(twelve);
    Option fourteen = new Option(pad, 14);
    sizeControls.add(fourteen);
    Option sixteen = new Option(pad, 16);
    sizeControls.add(sixteen);
    Option eighteen = new Option(pad, 18);
    sizeControls.add(eighteen);
    Option twenty = new Option(pad, 20);
    sizeControls.add(twenty);
    add(controls);
    add(sizeControls);
  }
}

/**
 *Takes a Pad Object and either a width int or a Color object
 *and returns an object that, when clicked changes the width
 *or color of the pen stroke respectively. 
 **/

class Option extends Canvas implements MouseListener {
  Graphics g;
  Color shade;
  Pad pad;
  int width;
  boolean isWidth = false;
  boolean isColor = false;
  public Option(Pad p, int width) {
    this.setBackground(Color.gray);
    addMouseListener(this);
    this.shade = Color.gray;
    this.width = width;
    this.setSize(20, 20);
    this.pad = p;
    this.isWidth = true;
    g = this.getGraphics();
  }
  public Option(Pad p, Color c) {
    this.setBackground(c);
    this.shade = c;
    this.setSize(20, 20);
    this.pad = p;
    addMouseListener(this);
    this.isColor = true;
  }
  public void paint(Graphics g) {
    if (isWidth) {
      g.setColor(Color.black); 
      int place = 10 - (int)(width/2);
      g.fillOval(place, place, width, width);
    }
  }
  public void mouseEntered(MouseEvent e) {}
  public void mouseExited(MouseEvent e) {}
  public void mouseReleased(MouseEvent e) {}
  public void mouseClicked(MouseEvent e) {}
  public void mousePressed(MouseEvent e) {
    if (isColor) pad.color = shade;
    if (isWidth) pad.width = width;
  }
}

/**
 *Provides a drawing surface that responds to a mouse dragging over it.
 */

class Pad extends Canvas implements MouseListener, MouseMotionListener {
  int oldX, oldY;
  int newX, newY;
  int width = 3;
  Color color = Color.black;
  boolean isDrawing = false;
  
  /**
   *The constructor creates a white surface, 350 by 300 that responds
   *to mouse clicking and dragging.
   */
  public Pad() {
    this.setBackground(Color.white);
    this.setSize(350, 300);
    addMouseMotionListener(this);
    addMouseListener(this);
  }
  public void mouseEntered(MouseEvent e) {}
  public void mouseExited(MouseEvent e) {}
  public void mouseReleased(MouseEvent e) {}
  public void mouseClicked(MouseEvent e) {}
  /**
   *Creates a single circle of the specified weight and color.
   */
  public void mousePressed(MouseEvent e) {
    Graphics g = getGraphics();
    g.setColor(color);
    int radius = (int)(width/5);
    g.fillOval(e.getX() - radius, e.getY() - radius, width, width);
    isDrawing = false;
  }
  
  /**
   *Stops any drawing that may be occuring
   */
  public void mouseMoved(MouseEvent e) {
    isDrawing = false;
  }
  
  /**
   *Creates a string of circles to follow the line drawn by the mouse.
   */
  public void mouseDragged(MouseEvent e) {
    int newX = e.getX();
    int newY = e.getY();
    /*oldX and oldY have been set and can be used to draw lines of circles*/
    if (isDrawing) {
      Graphics g = getGraphics();
      g.setColor(color);
      int xDist = Math.abs(newX - oldX);
      int yDist = newY - oldY;
      int radius = (int)(width/2);
      /* Motion is horizontal */
      if (yDist == 0) {
	/* right */
	if (oldX < newX) {
	  for (int i = oldX; i <= newX; i++) {
	    g.fillOval(i - radius, newY - radius, width, width);
	  }
	}
	/* left */
	else {
	  for (int i = oldX; i >= newX; i--) {
	    g.fillOval(i - radius, newY - radius, width, width);
	  }
	}
      }
      /* Motion is horizontal*/
      if (xDist == 0) {
	/* up */
	if (newY > oldY) {
	  for (int i = oldY; i <= newY; i++) {
	    g.fillOval(oldX - radius, i - radius, width, width);
	  }
	}
	/* down */
	else {
	  for (int i = oldY; i >= newY; i--) {
	    g.fillOval(oldX - radius, i - radius, width, width);
	  }
	}
      }
      /* Motion is not diagonal */
      else {
	double ratio = (double)yDist/(double)xDist;
	/*Motion is to the right */
	if (newX > oldX) {
	  for (int i = 0; i < xDist; i++) {
	    int yMove = (int)((double)i * ratio);
	    if (yMove > 100 || yMove < -100) yMove = 0;
	    g.fillOval(oldX + i - radius, oldY + yMove - radius, width, width);
	  }
	}
	/* Motion is to the left */
	if (oldX > newX) {
	  for (int i = 0; i < xDist; i++) {
	    int yMove = (int)((double)i * ratio);
	    if (yMove > 100 || yMove < -100) yMove = 0;
	    g.fillOval(oldX - i - radius, oldY + yMove - radius, width, width);
	  }
	}
      }
    }
    /* Toggle isDrawing to access the if-clause next time. */
    else {
      isDrawing = true;
    }
    /*Set newX and newY to oldX and oldY, respectively */
    oldX = newX;
    oldY = newY;
  }
}



