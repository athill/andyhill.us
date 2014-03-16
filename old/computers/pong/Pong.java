import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Button;
import java.awt.*;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseEvent;
import java.awt.event.*;

public class Pong extends Applet implements MouseMotionListener, Runnable, ActionListener {	
  private final Color PART_COLOR=(Color.yellow);
  private final int BALL_DIAMETER=25;
  private final int PADDLE_WIDTH=20;
  private final int PADDLE_HEIGHT=60;
  private int ballX = 20;
  private int ballY = 170;
  private final int PAD1X = 0;
  private int pad1Y = 170;
  private final int PAD2X = 580;
  private int pad2Y = 170;
  private int score1 = 0;
  private int score2 = 0;
  Thread kicker;
  private boolean up = true;
  private boolean right = true;
  private boolean startGame = true;
  private boolean endGame = false;
  private boolean playing = true;
  private boolean finished = false;
  private final int BALL_SPEED = 1;
  private final int PAD1Y_SPEED = 1;
  private final int PLAY_TO = 3;
  Graphics bufferGraphics;
  Image offscreen;
  Dimension dim;
  Button doButton;

	//Set up applet
  public void init() {
    setBackground(Color.black);
    resize(600,400);
    addMouseMotionListener(this);
    dim = getSize();
    offscreen = createImage(dim.width,dim.height);
    bufferGraphics = offscreen.getGraphics();
    doButton = new Button("RESTART");
    doButton.addActionListener(this);
    setLayout(new FlowLayout());
    add(doButton);	
  }
  //Draw playing field
  public void paint(Graphics g) {
    bufferGraphics.clearRect(0,0,dim.width,dim.height);
    bufferGraphics.setColor(PART_COLOR);
    bufferGraphics.fillOval(ballX,ballY,BALL_DIAMETER,BALL_DIAMETER);
    bufferGraphics.fillRect(PAD1X,pad1Y,PADDLE_WIDTH,PADDLE_HEIGHT);
    bufferGraphics.fillRect(PAD2X,pad2Y,PADDLE_WIDTH,PADDLE_HEIGHT);
    bufferGraphics.fillRect(299,0,2,400);
    bufferGraphics.drawString("COMPUTER: " + score1 + "        YOU: " +  score2, 10, 20);
    g.drawImage(offscreen,0,0,this);
    if (endGame) newGame(g); 	
  }	
  public void update(Graphics g) {
    paint(g);
  }
  //Start thread
  public void start() {
    if (kicker == null) {
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
    final int HALF_PAD_HEIGHT = 30;		
    while(!finished) {	         //thread is running.	
      while (playing) {
	repaint();			
	moveComputerPad();         
	if (startGame) startGame();			
	else {
	  if (up) {			//ball moving up	
	    if (ballY < 1) up = false;      //switch directions if top is reached
	    else ballY -= BALL_SPEED;  
	  }
	  else {
	    if (ballY > 399) up = true;
	    else ballY += BALL_SPEED;
	  }
	  if (right) {			//ball moving rightward	
	    if (ballX > 574) {            //if right side is reached
	      point1();              //score for computer
	    }
	    /*If ball is in zone where player paddle can hit it, 
	     *see if paddle is in right position to hit it*/
	    else if (ballX > (574 - PADDLE_WIDTH)) {
	      if ((ballY >= pad2Y) && (ballY < (pad2Y + HALF_PAD_HEIGHT))) {
		right = false;        //Top half of paddle
		up = true;
	      }
	      else if((ballY >= (pad2Y + HALF_PAD_HEIGHT)) 
		      && (ballY <=  pad2Y + PADDLE_HEIGHT)) { 
		right = false;         //Bottom half of paddle
		up = false;
	      }
	      ballX += BALL_SPEED;
	    }
	    /*Otherwise, keep going in the same direction*/
	    else ballX += BALL_SPEED;
	  }
	  /*Ball is moving to the left.*/
	  else {
	    if (ballX < 1) {    //if left side is reached
	      point2();	 // score for player.		
	    }
	    /*If ball is in zone where computer paddle can hit it,
	     *see if paddle is in right position to hit it. */
	    else if (ballX < (1 + PADDLE_WIDTH)) {
	      if ((ballY >= (pad1Y - 3)) && (ballY < (pad1Y + HALF_PAD_HEIGHT))) {
		right = true;        //top half of paddle
		up = true;				
	      }				
	      else if ((ballY >= (pad1Y + HALF_PAD_HEIGHT)) 
		       && (ballY <= (pad1Y + PADDLE_HEIGHT))){
		right = true;         //bottom half of paddle
		up = false;
	      }
	      ballX -= BALL_SPEED;
	    }				
	    else ballX -= BALL_SPEED;
	  }
	}
	try {
	  Thread.sleep(10);
	}
	catch(InterruptedException e) {
	  finished = true;
	}
      }
    }
  }
  //Start game
  public void startGame() {
    ballX = 20;
    ballY = 170;
    score1 = 0;
    score2 = 0;
    startGame = false;
    finished = false;
    endGame = false;
    playing = true;
    right = true;
    int upOrDown = (int)(Math.random() * 2);
    if (upOrDown == 1) up = true;
    else up = false;
    repaint();
  } 
  public void point1() {
    score1++;
    ballX = 5;
    right = true;
    int upOrDown = (int)(Math.random() * 2);
    if (upOrDown == 1) up = true;
    else up = false;
    if (score1 == PLAY_TO) {
      endGame = true;				
    }	
  }
  public void point2() {
    score2++;
    ballX = 570;
    right = false;
    int upOrDown = (int)(Math.random() * 2);
    if (upOrDown == 1) up = true;
    else up = false;
    if (score2 == PLAY_TO) {
      endGame = true;
    }
  }
	
  //Handle mouse events
  public void mouseMoved(MouseEvent e) {
    mouseDragged(e);
  }
  public void mouseDragged(MouseEvent e) {
    int mouseY=e.getY();
    if (mouseY < 0) pad2Y = 0;
    else if (mouseY > 340) pad2Y = 340;
    else pad2Y = mouseY;
    //repaint();
  }

  //Moves computer paddle
  public void moveComputerPad() {
    if (!right) {
      int rand = (int)(Math.random() * 10);
      if (rand < 8) {
	if (pad1Y < ballY  && pad1Y < 341) pad1Y += PAD1Y_SPEED;
	else if (pad1Y > ballY) pad1Y -= PAD1Y_SPEED;
      }
    }
  }
  public void newGame(Graphics g) {
    if (score1 == PLAY_TO) {
      g.drawString("The computer wins!!!", 200, 200);
    }
    else g.drawString("You win!!!", 250,200);
    playing = false;
    repaint();
  }
  public void actionPerformed(ActionEvent e) {
    startGame();
  }	
}








