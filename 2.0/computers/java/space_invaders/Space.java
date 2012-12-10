import java.applet.Applet;
import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.Dimension;
import java.awt.event.MouseMotionListener;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
import java.awt.event.WindowEvent;


public class Space extends Applet implements MouseMotionListener, MouseListener, Runnable {
  private Graphics bufferGraphics;            //used for double-buffereing
  private Image offscreen;                    //ditto
  private Dimension dim;                      //size of applet
  static Player player;                       //Playing piece
  private int oldX;                           //used in monitoring mouse motion
  private boolean inApplet = true;            //indicates whether cursor is inside applet
  final boolean up = true;                    //used for bullet direction
  final boolean down = false;
  public static Bullet bullets[] = new Bullet[30];   //bullets in action at one time
  private int bul_pos = 0;                           //current bullet in array
  public static Invader invaders[][] = new Invader[3][5];  //the space invaders
  private Thread kicker;                                  //thread used to animate space invaders
  public static Block blocks[] = new Block[4];            //protection blocks
  public void init() {
    for (int i = 0; i < 20; i++) {                     //initialize bullets to null 
      bullets[i] = null;
    }
    setBackground(Color.black);                        
    resize(400, 400);
    player = new Player();
    addMouseMotionListener(this);                      //for x-y movement
    addMouseListener(this);                            //for firing, seeing if cursor is in applet
    for (int i = 0; i<3; i++) {                        //initialize space invaders
      for (int j = 0; j<5; j++) {
	invaders[i][j] = new Invader(j*40, i*40, this);
      }
    }
    for (int i = 0; i<4; i++) {                        //initialize protection blocks
      blocks[i] = new Block((i * 100) + 20, 320);
    }
    dim = getSize();
    offscreen = createImage(dim.width,dim.height);
    bufferGraphics = offscreen.getGraphics();
    System.out.println("Init");
    start();
  }

  public void paint(Graphics g) {
    bufferGraphics.clearRect(0,0,dim.width,dim.height);
    player.draw(bufferGraphics);
    for (int i = 0; i < 20; i++) {
      if (bullets[i] != null) 
	bullets[i].draw(bufferGraphics);
    }
    for (int i = 0; i<3; i++) {
      for (int j = 0; j < 5; j++) {
	if (invaders[i][j] != null) 
	  invaders[i][j].draw(bufferGraphics);
      }
    }
    for (int i = 0; i<4; i++) {
      blocks[i].draw(bufferGraphics);
    }
    bufferGraphics.setColor(Color.white);               
    bufferGraphics.drawString("Score: " + player.score      //show player stats
			      + "  Lives: " + player.lives, 20, 20);
    g.drawImage(offscreen,0,0,this);                        //swap buffers
  }
  //override to allow double-buffering
  public void update(Graphics g) {
    paint(g);
  }
  //Start thread
  public void start() {
    if(kicker==null) {
      kicker = new Thread(this);
      System.out.println("Starting");
      kicker.start();
    }
  }
  //Terminate thread
  public void stop() {
    System.out.println("stopping");
    kicker.interrupt();
    kicker = null;
  }
  //Main loop
  public void run() { 
    boolean finished = false;        //Game over
    boolean isRight = true;          //space invaders moving to the right
    int border=0;               //when s.i.'s should move down/change direction
    int count= 0;               //determine frequency of s.i. bullets
    int shooterX;              //determine which s.i. is shooting
    int shooterY = 0;
    boolean looking, allDead;  //booleans for determining which s.i. is shooting and if all are dead
    while (!finished) {
      for (int i = 0; i < 20; i++) {
	if (bullets[i] != null) 
	  bullets[i].doBullets();
      }
      allDead = true;          //start as true set to false if any are not null
      for (int i = 0; i < 3; i++) {
	for (int j = 0; j < 5; j++) {
	  if (invaders[i][j] != null &&               //player a loses life if collision with s.i.
	      invaders[i][j].x >= player.position && 
	      invaders[i][j].x <= player.position + 30 &&
	      invaders[i][j].y >= 335)
	    player.lives--;
	  if (invaders[i][j] != null) {
	    allDead = false;
	    break;
	  }
	}
      }
      if (allDead) {         
	nextRound();
      }
      if (player.lives < 1) {
	finished = true;
	stop();
      }
      /*chooses a random column and tries to pick the lowest row
	with a s.i. in it to fire from. If the column is empty, 
	cycle through the columns until a s.i. is found*/
      count = (++count)%3;
      if (count == 0) {
	shooterX = (int)Math.floor(Math.random() * 5.0);
	if (shooterX == 5) shooterX--;
	do {
	  looking = false;
	  if (invaders[2][shooterX] != null) shooterY = 2;
	  else if (invaders[1][shooterX] != null) shooterY = 1;
	  else if (invaders[0][shooterX] != null) shooterY = 0;
	  else looking = true;
	  if (looking) shooterX = (shooterX + 1)%5;
	} while (looking);
	Bullet bullet = new Bullet(down, invaders[shooterY][shooterX].x + 10, 
				   invaders[shooterY][shooterX].y + 60,
				   bul_pos, this);
	bullets[bul_pos] = bullet;
	bul_pos = (++bul_pos)%30;
      }
      /*Determine left edge of s.i.s to know when to move down/go right  */
      if (!isRight) {
	for (int i = 0; i<5; i++) {
	  if (invaders[0][i] != null || 
	      invaders[1][i] != null ||
	      invaders[2][i] != null) {
	    border = i;
	    break;
	  }
	}
	/*If at left edge, move down and switch directions */
	if ((invaders[0][border] != null && invaders[0][border].x < 20) ||
	    (invaders[1][border] != null && invaders[1][border].x < 20) ||
	    (invaders[2][border] != null && invaders[2][border].x < 20)) {
	  for (int i = 0; i<3; i++) {
	    for (int j = 0; j < 5; j++) {
	      if (invaders[i][j] != null) 
		invaders[i][j].y += 40;
	    }
	  }
	  isRight = true;
	}
	/*Otherwise, keep moving left */
	else {
	  for (int i = 0; i<3; i++) {
	    for (int j = 0; j < 5; j++) {
	      if (invaders[i][j] != null)
		invaders[i][j].x -= 20;
	    }
	  }
	}
      }
      /*Moving right, determine right edge of s.i.s */
      else {
	for (int i = 4; i>=0; i--) {
	  if (invaders[0][i] != null || 
	      invaders[1][i] != null ||
	      invaders[2][i] != null) {
	    border = i;
	    break;
	  }
	}
	/*If at edge, move down and start moving left */
	if ((invaders[0][border] != null && invaders[0][border].x > 360) ||
	    (invaders[1][border] != null && invaders[1][border].x > 360) ||
	    (invaders[2][border] != null && invaders[2][border].x > 360)) {
	  for (int i = 0; i<3; i++) {
	    for (int j = 0; j < 5; j++) {
	      if (invaders[i][j] != null) 
		invaders[i][j].y += 40;
	    }
	  }
	  isRight = false;
	}
	/*Otherwise, keep moving right */
	else {
	  for (int i = 0; i<3; i++) {
	    for (int j = 0; j < 5; j++) {
	      if (invaders[i][j] != null)  
		invaders[i][j].x += 20;
	    }
	  }
	}
      }

      repaint();
      try {
	Thread.sleep(250);
      }

      catch (InterruptedException e) {
	finished = true;
      }
    }
  }
  public void nextRound() {
    for (int i = 0; i<3; i++) {                        //initialize space invaders
      for (int j = 0; j<5; j++) {
	invaders[i][j] = new Invader(j*40, i*40, this);
      }
    }
    for (int i = 0; i<4; i++) {                        //initialize protection blocks
      blocks[i] = new Block((i * 100) + 20, 320);
    }
  }
    
  /*Moves player along x axis according to mouse movements */  
  public void mouseMoved(MouseEvent e) {
    int x = e.getX(); 
    if (!inApplet) {
	int deltaX = x - oldX;
	if (deltaX > 0 && player.position <= 390 || 
	    deltaX < 0 && player.position >=0)
	  player.position += x - oldX;
    }
    else inApplet = false;
    oldX = x;
    repaint();
  }
  public void mouseDragged(MouseEvent e) {
    mouseMoved(e); 
  }
  public void mousePressed(MouseEvent e) {
    mouseClicked(e);
  }
  public void mouseReleased(MouseEvent e) {
  }
  public void mouseEntered(MouseEvent e) {
    inApplet = true;
  }
  public void mouseExited(MouseEvent e) {
    inApplet = false;
  }
  /*Shoots a bullet upward from the player's ship */ 
  public void mouseClicked(MouseEvent e) {
    Bullet bullet = new Bullet(up, player.position, 375,
			       bul_pos, this);
    bullets[bul_pos] = bullet;
    bul_pos = (++bul_pos)%30; 

  }
}


/*Sets up and draws player*/
class Player {
  int lives, position, score;
  Color color;
  public Player () {
    lives = 3;
    position = 200;
    color = Color.white;
    score = 0;
  }
  public void draw(Graphics g) {
    g.setColor(color);
    for (int y = 375; y<=400; y+=5) {
      int width = y - 375;
      int x = position - (width/2);
      g.fillRect(x, y, width, 5);
    }
  }
}


/*Sets up, draws, and animates bullets. */    
class Bullet {
  boolean dir;    //up/down direction bullet travels
  int x, y;       //starting position of bullet
  int pos;        //position of bullet in bullets[]
  Applet app;     //Applet instantiating the bullet
  public Bullet(boolean direction, int x, int y, int pos, Applet applet) {
    this.x = x;
    this.y = y;
    this.dir = direction;
    this.pos = pos;
    this.app = applet;
  }
  //Main loop
  public void doBullets() { 
    /*Check for collisions with Space Invaders */
    for (int i = 0; i < 3; i++) {
      for (int j = 0; j < 5; j++) {
	if (Space.invaders[i][j] != null && Space.invaders[i][j].available == true) {
	  if (Space.invaders[i][j].collision(this) == 0) {
	    Space.player.score += 10;
	    Space.bullets[pos] = null;
	    Space.invaders[i][j] = null;
	    return;
	  }
	}
      }
    }
    /*Check for collisions with protection blocks */
    for (int i = 0; i < 4; i++) {
      if (Space.blocks[i].collision(this) == 0) {
	Space.bullets[pos] = null;
	return;
      }
    }
    /*Bullet is going up*/
    if (dir)   {          
      if (y > 0) {
	y -= 5; 
      }
      else {
	Space.bullets[pos] = null;
      }
    }
    /*Bullet is going down */
    else {
      if (y < 400) {
	y += 5;
      }
      else {
	Space.bullets[pos] = null;
      }
    }
  }
  void draw(Graphics g) {
    g.setColor(Color.white);
    g.fillRect(x, y, 2, 6);
  }
}

/*Instantiates and draws a Space Invader */
class Invader {
  int x, y;              //starting position of s.i.
  boolean open;          //whether s.i.'s legs are in open/closed position
  Applet app;            //Applet which instantiated the space invader
  boolean available;     //Used as mutex for concurrency issues
  Invader(int x, int y, Applet app) {
    this.x = x;
    this.y = y;
    this.app = app;
    open=true;
    available = true;
  }
  void draw(Graphics g) {
    g.setColor(Color.red);
    g.fillRect(x, y, 20, 20);
    if (open) {
      g.drawLine(x+5, y+20, x, y+30);
      g.drawLine(x+15, y+20, x+20, y+30);
    }
    else {
      g.drawLine(x+5, y+20, x+10, y+30);
      g.drawLine(x+15, y+20, x+10, y+30);      
    }
    open = !open;
    g.setColor(Color.black);
    g.fillRect(x+5, y+5, 3, 3);
    g.fillRect(x+15, y+5, 3, 3);
  }
  /*Returns 0 if bullet collides with space invader, 1 otherwise */
  synchronized int collision(Bullet bullet) {
    available = false;
    if (bullet.x > x && bullet.x < (x + 20) &&
	bullet.y > y && bullet.y < (y + 20)) {
      Space.bullets[bullet.pos] = null;
      available = true;
      return 0;
    }
    available = true;
    return 1;
  }
}

/*Instantiates and draws a protection block */
class Block {
  int x, y;                                 //Position of protection block
  boolean available;                        //Mutex used for concurrency issues
  boolean draw[][] = new boolean[5][5];   //Matrix of rectangles used to break apart block
  Block(int x, int y) {
    this.x = x;
    this.y = y;
    available = true;
    /*Instantiate matrix to all true(draw all sub-blocks */
    for (int i = 0; i < 5; i++) {
      for (int j = 0; j < 5; j++) {
	draw[i][j] = true;
      }
    }
  }
  /*Draws all sub-blocks whose corresponding matrix value is true */
  void draw(Graphics g) {
    g.setColor(Color.yellow);
    for (int i = 0; i<5; i++) {
      for (int j = 0; j < 5; j++) {
	if (draw[i][j]) 
	  g.fillRect(x + (i*9), y + (j*9), 9, 9);
      }
    }
  }
  /*Checks to see if a bullet hit the block. If not, a 1 is returned.
   If so, the sub-block thatwas hit is set to false and a zero is returned.*/
  synchronized int collision(Bullet bullet) {
    available = false;
    for (int i = 0; i<5; i++) {
      for (int j = 0; j < 5; j++) {
	if (bullet.x >= x + (i*3) && bullet.x <= x + 3 + (i*3) && 
	    bullet.y >= y + (j*3) && bullet.y <= y + 3 + (j*3)) {
	  if (draw[i][j]) {
	    draw[i][j] = false; 
	    available = true;
	    return 0;
	  }
	}
      }
    }
    available = true;
    return 1;
  }
}
