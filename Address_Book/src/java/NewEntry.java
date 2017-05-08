
import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletConfig;
import javax.servlet.ServletContext;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebInitParam;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet(
        name = "newEntry",
        urlPatterns = {"/newEntry", "/search"}, //annotations
        initParams = {
            @WebInitParam(name = "filepath", value = "/addressBook.txt")}
)
public class NewEntry extends HttpServlet {
    
    String filename;
    String path;
    
    @Override
    public void init() throws ServletException {
        
        ServletConfig config = getServletConfig();          //get the value of the init-parameter
        filename = config.getInitParameter("filepath");
        ServletContext sc = config.getServletContext();
        path = sc.getRealPath(filename);
    }
    
    protected void processRequestPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        synchronized (this) {
            PrintWriter out = response.getWriter();
            HttpSession session = request.getSession();
            String name = request.getParameter("name1");
            String details = request.getParameter("name2");
            
            if (session.isNew()) {
                AddressBook contact = new AddressBook();   //initialize the addressbook
                contact.addContact(name, details);
                session.setAttribute("book", contact);
                out.println("New session created...!!!");
            } else {
                AddressBook addressbook = (AddressBook) session.getAttribute("book");
                addressbook.addContact(name, details);
                out.println("New contact added to the exist session");
                
            }
        }
    }
    
    protected void processRequestGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        HttpSession session = request.getSession();
        response.setContentType("text/html;charset=UTF-8");     //process request parameters and return details of searched name
        String name = request.getParameter("name3");
        PrintWriter out = response.getWriter();
        if (session.isNew()) {
            AddressBook contact = new AddressBook();   //initialize the addressbook
            session.setAttribute("book", contact);
            out.println("Welcome new user...!!!");
            out.println("New session created...!!!");
        } else {
            AddressBook addressbook = (AddressBook) session.getAttribute("book");
            out.println("Contact Details : "+addressbook.search(name));
        }
        
    }
    
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequestGet(request, response);
    }
    
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequestPost(request, response);
    }
    
    @Override
    public String getServletInfo() {
        return "Short description";
    }


}
