import java.applet.Applet;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseEvent;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Dimension;
import java.lang.Integer;

/*********************************************
 * Applet has 3 scoll bars that control the  *
 * red, green and blue values of a box       *
 * respectively.                             *
 *********************************************/      

public class SliderColorControl extends Applet {
    private SliderFactory sliderFactory; 
    private static Color rectangleColor;
    private Graphics g;
    Graphics buffer;
    Image offscreen;
    Dimension dim;
    public void init() {
	setBackground(Color.black);
	dim = getSize();
	offscreen = createImage(dim.width,dim.height);
	buffer = offscreen.getGraphics();
	sliderFactory = new SliderFactory(this, buffer, offscreen);
	sliderFactory.makeSlider(200, 50, 250, 0, 255, 150);
	sliderFactory.makeSlider(275, 50, 250, 0, 255, 150);
	sliderFactory.makeSlider(350, 50, 250, 0, 255, 150);
	g = this.getGraphics();
    } 
    public void paint(Graphics g) {
	buffer.clearRect(0,0,dim.width,dim.height);
	rectangleColor = new Color(sliderFactory.sliders[0].value, sliderFactory.sliders[1].value, sliderFactory.sliders[2].value);
	buffer.setColor(rectangleColor);
	buffer.fillRect(20, 50, 150, 250);
	buffer.setColor(Color.white);
	String hexidecimalize = toHexidecimal(sliderFactory.sliders[0].value)+ toHexidecimal(sliderFactory.sliders[1].value)+ toHexidecimal(sliderFactory.sliders[2].value);
	buffer.drawString("Hexidecimal representation: " + hexidecimalize,100, 350);
	sliderFactory.paint();
	g.drawImage(offscreen,0,0,this);
    }
    public void update(Graphics g) {
	paint(g);
    }
    
    //Converts position of scroll bar to hexadecimal representation
    public String toHexidecimal(int value) {
	int temp = value/16;
	int temp2 =  value%16;
	Integer temp3 = new Integer(temp);
	Integer temp4 = new Integer(temp2);
	String tens="0";
	String ones="0";
	if (temp < 10) tens = temp3.toString();
	else if (temp == 10) tens = "A";
	else if (temp == 11) tens = "B";
	else if (temp == 12) tens = "C";
	else if (temp == 13) tens = "D";
	else if (temp == 14) tens = "E";
	else if (temp == 15) tens = "F";
	if (temp2 < 10) ones = temp4.toString();
	else if (temp2 == 10) ones = "A";
	else if (temp2 == 11) ones = "B";
	else if (temp2 == 12) ones = "C";
	else if (temp2 == 13) ones = "D";
	else if (temp2 == 14) ones = "E";
	else if (temp2 == 15) ones = "F";
	String str;
	str = tens.concat(ones);
	return str;
    }
}

//Creates any number of Slider objects

class SliderFactory implements MouseMotionListener {
    private int x, y, length;
    private final int DEFAULT_MINIMUM = 0;
    private final int DEFAULT_MAXIMUM = 100;
    private final int DEFAULT_VALUE = 50;
    private int minimum, maximum, value;
    private Applet applet;
    private int count = 3;
    Slider[] sliders = new Slider[count];
    private int index = 0;
    private boolean[] isSliding = new boolean[count];
    static int ballY;
    Graphics buf;
    Image off;
    SliderFactory(Applet applet, Graphics buf, Image off) {
	this.applet = applet;
	this.buf = buf;
	this.off = off;
	applet.addMouseMotionListener(this);
    }
    public void makeSlider(int x, int y, int length) {
	makeSlider(x, y, length, DEFAULT_MINIMUM, DEFAULT_MAXIMUM, DEFAULT_VALUE);
    }
    public void makeSlider(int x, int y, int length, int minimum, int maximum, int value) {
	Slider slider = new Slider(applet, buf, off, x, y, length, minimum, maximum, value);
	sliders[index] = slider;
	index++;
    }
    public void paint() {
	for (int i = 0; i < 3; i++) {
	    sliders[i].paint();
	}
    }
    public int getMinimum() {return minimum;}
    public int getMaximum() {return maximum;}
    public int getValue() {return value;}
    public void mouseMoved(MouseEvent e) {
	for (int i=0; i < count; i++) {
	    isSliding[i] = false;
	}
    }
    public void mouseDragged(MouseEvent e) {
	int mouseX = e.getX();
	int mouseY = e.getY();
	int BALL_RADIUS = 25;
	int BAR_WIDTH = 40;
	for (int i = 0; i < count; i++) {
	    ballY = (int)((255 - sliders[i].value) * .7483 + 50);
	    int ballCenterX = sliders[i].x + BAR_WIDTH /2;
	    int ballCenterY = ballY + BALL_RADIUS;
	    double aSquared = Math.pow(mouseX - ballCenterX, 2);
	    double bSquared = Math.pow(mouseY - ballCenterY, 2);
	    int hypotenuse = (int)Math.sqrt(aSquared + bSquared);
	    if (hypotenuse <= BALL_RADIUS) isSliding[i] = true;
	    if (isSliding[i]) {
		ballY = mouseY;
		sliders[i].value = 255 - ((int)(1.275 * (ballY - 50)));
		if (sliders[i].value < sliders[i].minimum) {
		    sliders[i].value = sliders[i].minimum;
		}
		if (sliders[i].value > sliders[i].maximum) {
		    sliders[i].value = sliders[i].maximum;
		}
		applet.repaint();
	    }
	}
    }
}
class Slider {
    private final int BALL_DIAMETER = 50;
    private final int BAR_WIDTH = 40;
    private final Color BAR_COLOR = Color.lightGray;
    private final Color BALL_COLOR = Color.blue;
    private final int BALL_RADIUS = BALL_DIAMETER / 2;
    private int barCenter;
    private int ballY;
    Applet applet;
    int x, y, length;
    int minimum, maximum, value;
    Graphics buffer;
    Image off;
    public Slider (Applet applet, Graphics buf, Image off, int x, int y, int length, int minimum, int maximum, int value) {
	this.applet = applet;
	this.x = x;
	this.y = y;
	this.minimum = minimum;
	this.maximum = maximum;
	this.value = value;
	this.length = length;
	this.buffer = buf;
	this.off = off;
    }
    public void addSliderListener(Slider slide){}
    public void paint() {
	ballY = (int)((255 - value) * .7843 + 50);
	buffer.setColor(BAR_COLOR);
	buffer.fillRect(x, y, BAR_WIDTH, length);
	buffer.setColor(BALL_COLOR);
	barCenter = x + BAR_WIDTH / 2;
	buffer.fillOval(barCenter - BALL_RADIUS, ballY, BALL_DIAMETER, BALL_DIAMETER);
    }
}

