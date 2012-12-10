import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Dimension;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseEvent;


public class BallBounce extends Applet implements Runnable, MouseMotionListener {
  private Color ballColor=(Color.white);
	Thread kicker;
	
	private int ballX = 100;		//Ball start position & size
	private int ballY = 100;
	private final int BALL_DIAMETER = 50;

	private boolean falling = true;		//booleans to determine direction
	private boolean leftward = true;
	private final int SPEED = 2;		//lateral speed of ball
	private int gravity = 1;
	Graphics g;
	private boolean holding = false;	//mouse controlling ball
	private boolean dropping = false;	//mouse drops ball
	public Graphics bufferGraphics;
	Image offscreen;
	Dimension dim;
//Set up Applet
	public void init() {	
		setBackground(Color.blue);
		resize(400, 400);
		addMouseMotionListener(this);
		dim = getSize();
		offscreen = createImage(dim.width,dim.height);
		bufferGraphics = offscreen.getGraphics();
	}

//Draw the ball
	public void paint(Graphics g) {
		bufferGraphics.clearRect(0,0,dim.width,dim.height);
		bufferGraphics.setColor(Color.gray);
		bufferGraphics.fillOval(ballX, 390, BALL_DIAMETER, gravity);
		bufferGraphics.setColor(ballColor);
		bufferGraphics.fillOval(ballX,ballY,BALL_DIAMETER,BALL_DIAMETER);
		g.drawImage(offscreen,0,0,this);
	}
	public void update(Graphics g) {
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
		int suspend = 0;
		while(!finished) {
			this.repaint();
			gravity = (int)(Math.pow(1.011,ballY-99));
			if (falling) {
				if (ballY > 340) {	//see if ball has reached ground 
					ballY = 340;	
					falling = false;
					dropping = false;
				}
				else {
					if ((ballY < 144) && dropping) gravity = 1;
					ballY += gravity;
				}
			}
			else {
				if ((ballY < 144) && !(dropping)) {//or top of arc, if so, 
					ballY = 144;		//toggle boolean
					falling = true;
					suspend++;
					if (suspend == 2) {
						suspend = 0;
					}
				}
				else {
					ballY -= gravity;
				}
			}
			if (dropping){}			//no lateral movement if dropping
			else if (leftward) {
				if (ballX < 5) {	//see if ball has reached left 
					ballX = 0;	//border
					leftward = false;
				}
				else ballX -= SPEED;
			}
			else {
				if (ballX > 340) {	//or right, if so, toggle
					ballX = 350;	//boolean
					leftward = true;
				}
				else ballX += SPEED;
			}
			try {				//pause for 200ms
				Thread.sleep(50);
			}
			catch(InterruptedException e) { //stop if interrupted
				finished = true;
			}
		}
	}
	public void mouseMoved(MouseEvent e) {
		holding = false;	
	}
	public void mouseDragged(MouseEvent e) {
		int mouseX = e.getX();
		int mouseY = e.getY();
		final int BALL_RADIUS = BALL_DIAMETER / 2;
		int ballCenterX = ballX + BALL_RADIUS;
		int ballCenterY = ballY + BALL_RADIUS;
		double aSquared = Math.pow(mouseX-ballCenterX,2);
		double bSquared = Math.pow(mouseY-ballCenterY,2);
		int hypotenuse = (int)Math.sqrt(aSquared + bSquared);
		if (hypotenuse <= BALL_RADIUS) holding = true;
		if (holding) {
			dropping = true;
			falling = true;
			if (mouseX > 350) ballX = 350;
			else if (mouseX < 0) ballX = 0;
			else if (mouseY > 350) ballY = 350;
			else if (mouseY < 0) ballY = 0;
			else {
				ballX = mouseX;
				ballY = mouseY;
			repaint();
			}
		}
	}
}
		
		

