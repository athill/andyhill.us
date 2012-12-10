import java.net.*;
import java.io.*;

class NetworkServer implements Runnable {
    private int port, maxConnections;
    File file;
    FileReader readFile;
    FileWriter writeFile;
    BufferedWriter bw;
    String return_thing = "\nEOF";
    String returner = "";
    int connectNum = 0;
    PrintWriter writers[] = new PrintWriter[10];

    public NetworkServer(int port, int maxConnections) {
	setPort(port);
	setMaxConnections(maxConnections);
	try {
	    file = new File("chatter");
	    writeFile = new FileWriter("chatter", false);
	    readFile = new FileReader(file);
	} catch(IOException ioe) {
	    System.out.println("IOException: " + ioe);
	    ioe.printStackTrace();
	}      
    }
    public void listen() {
	int i = 0;
	try {
	    ServerSocket listener = new ServerSocket(port);
	    DatagramSocket server;
	    while((i++ < maxConnections) || maxConnections == 0) {
		server = listener.accept();
		handleConnection(server);
	    }
	} catch(IOException ioe) {
	    System.out.println("IOException: " + ioe);
	    ioe.printStackTrace();
	}
    }
    public void handleConnection(Socket server) {  
	Server.connections[connectNum] = new Connection(this, server, connectNum);
	Server.connections[connectNum].start();
    }
    public void run() {
	connectNum = (connectNum++)%10;
	Connection currentThread = (Connection)Thread.currentThread();
	try {
	    handleConnection2(currentThread.getSocket());
	}
	catch(IOException ioe) {
	    System.out.println("IOException(run)" + ioe);
	    ioe.printStackTrace();
	}
    }
	
  protected void handleConnection2(Socket server) 
    throws IOException {
    byte sendBuf[] = new byte[256];
    DatagramPacket dp = new DatagramPacket(sendBuf, 256);
    server.receive(dp);
    String next = new String(dp.getData());      
    if (next.equals(null)) server.close();
    else {
      String current = doFileStuff(next);
      System.out.println("Generic Network Server: Got connection from" + 
			 server.getInetAddress().getHostName() + "\n" +
			 "with first line '" + next + "'");
      for (int i = 0; i < 10; i++) {
	if (connections[i]!=null)
	  connections[i].serverSocket.send(current);
      }
    }
  }
  protected String doFileStuff(String now) {
    DataInputStream dis = null; 
    String record = null; 
    int recCount = 0; 
    BufferedWriter bw;
    returner = now + "\n" + returner;
    System.out.println(returner + return_thing);
    return returner + return_thing;  
  }
  public int getMaxConnections() {
    return(maxConnections);
  }
  public void setMaxConnections(int maxConnections) {
    this.maxConnections = maxConnections;
  }
  public int getPort() {
    return(port);
  }
  public void setPort(int port) {
    this.port = port;
    }
}
public class Server {
  public static Connection connections[] = new Connection[10];
  
  public static void main(String[] args) {
    int port = 8088;
    if (args.length > 0) {
      port = Integer.parseInt(args[0]);
	}
    
    for (int i=0; i<10; i++) {
      connections[i] = null;
    }
    NetworkServer nwServer = new NetworkServer(port, 5);
    nwServer.listen();
  }
}

class Connection extends Thread {
  private Socket serverSocket;
  private int connect;

  public Connection(Runnable serverObject, DatagramSocket serverSocket, 
		    int connect) {
    super(serverObject);
	this.serverSocket = serverSocket;
	this.connect = connect;
  }
  public Socket getSocket() {
    return serverSocket;
  }
    public int getConnect() {
      return connect;
    }
}









