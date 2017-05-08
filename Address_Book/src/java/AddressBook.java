import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashMap;
import java.util.Set;
import javax.servlet.http.HttpServlet;

public class AddressBook extends HttpServlet {

    HashMap<String, String> map = new HashMap<>();

    public AddressBook() {

    }

    //read from file and create Address Book
    public void initAddressBook(String fileName) {

        try {
            FileReader reader = new FileReader(fileName);
            BufferedReader buffer = new BufferedReader(reader);  //read the file and load to hash map

            String line = "";
            while ((line = buffer.readLine()) != null) {

                String[] arr = line.split(",", 2);
                map.put(arr[0], arr[1]);
            }

        } catch (FileNotFoundException e) {
            System.out.println("FileNotFoundException");
        } catch (IOException e) {
        }
        //Create your address book
    }

    //search details of the requested contact in the address book
    public String search(String name) {

        return map.get(name);  //earch the hash map
    }

    public void writeFile(String filepath) {   //write hashmap to file

        FileWriter writer;
        try {
            writer = new FileWriter(filepath);
            try (BufferedWriter bufferedWriter = new BufferedWriter(writer)) {
                Set key = this.map.keySet();
                for (Object str : key) {

                    String details = map.get(str.toString());
                    String line = str.toString() + ", " + details;
                    bufferedWriter.write(line);
                    bufferedWriter.newLine();
                    bufferedWriter.flush();
                }
            }
        } catch (IOException e) {
        }
    }
    
     public void addContact(String key, String value) throws IOException {  //add contact to map
  
        map.put(key, value);
    }
}
