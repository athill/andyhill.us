import java.net.*;
import java.io.*;
import java.applet.Applet;
import java.awt.*;
import java.awt.event.*;

import java.net.URL;

class NetworkClient {
  protected String host;
  protected int port;
  protected String uname;
  static DatagramSocket client;
  
    public NetworkClient(String uname, String host, int port) {
	this.host=host;
	this.port = port;
	this.uname = uname;
    }
    public void connect() {
	while(true) {
	    try {
		client = new DatagramSocket(port);
		handleConnection(client);
	    } catch(IOException ioe) {
		Client.ta.setText("shit2");		
		System.out.println("IOException" + ioe);
		ioe.printStackTrace();
		System.exit(0);
	    }
	}
    }
    protected void handleConnection(DatagramSocket client) throws IOException {
      try {
	byte[] sendBuf = new byte[2560];
	DatagramPacket dp = new DatagramPacket(sendBuf, 2560);
	client.receive(dp);
	String received = new String(dp.getData());      
	Client.ta.setText(received);
      } catch (IOException e) {
	System.out.println("Applet socket.send failed:");
	e.printStackTrace();
	return;
      }
    }
    
    public String getHost() {
    return(host);
    }
    public int getPort() {
	return(port);
    }
}

class SocketUtil {
    public static BufferedReader getReader(Socket s) 
	throws IOException {
	return(new BufferedReader(new InputStreamReader(s.getInputStream())));
    }
    
    public static PrintWriter getWriter(Socket s) 
	throws IOException {
	return(new PrintWriter(s.getOutputStream(), true));
    }
}

public class Client extends Applet {
    Panel panel = new Panel();
    public static TextField tf = new TextField(20);
    public static Label label = new Label("Username for current session:", Label.RIGHT);
    SendButton send = new SendButton("Send");
    public static TextArea ta = new TextArea(10, 10);
    public static String uname = "";

    public void init() {
	setBackground(Color.yellow);
	setLayout(new BorderLayout());
	add(panel, BorderLayout.NORTH);
	panel.setBackground(Color.yellow);
	panel.setLayout(new BorderLayout());
	panel.add(label, BorderLayout.WEST);
	label.setBackground(Color.yellow);
	panel.add(tf, BorderLayout.CENTER);
	tf.setBackground(Color.white);
	panel.add(send, BorderLayout.EAST);
	send.setBackground(Color.yellow);
	add(ta, BorderLayout.SOUTH);
	ta.setBackground(Color.white);
        ta.setForeground(Color.black);
	ta.setText("What the hell is going on?");
    }

}

class SendButton extends Button implements MouseListener {
    boolean first = true;
    NetworkClient nwClient;
    String un, msg;
    String host = "andyhill.us";
    int port = 8088;
    int i = 0;

    SendButton(String s) {
	super(s);
	addMouseListener(this);
    }
    public void mouseEntered (MouseEvent e) {}
    public void mouseExited (MouseEvent e) {}
    public void mouseReleased(MouseEvent e)  {}
    public void mouseClicked(MouseEvent e) {}
    public void mousePressed(MouseEvent e) {
	if (first == true) {
	    first = false;
	    Client.label.setText("Add to chat: ");
	    un = Client.tf.getText();
	    Client.uname = un;
	    Client.tf.setText("");
	    nwClient = new NetworkClient(un, host, port);
	    nwClient.connect();
	}
	else {
	  try {
	    byte[] sendBuf = new byte[256];
	    Client.tf.setText("");
	    Client.ta.setText("Ya never know : " + i++);
	    msg = Client.tf.getText();
	    msg = un + ": " + msg;
	    DatagramPacket sender = new DatagramPacket(sendBuf, 256);
	    NetworkClient.client.send(sender);
	    Client.ta.setText("trying");
	  } catch (IOException er) {
	    System.out.println("Applet socket.send failed:");
	    er.printStackTrace();
	    return;
	  }
	}
    }
}







