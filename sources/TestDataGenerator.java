import java.sql.*;
import oracle.jdbc.driver.*;

public class TestDataGenerator {

  public static void main(String args[]) {

    try {
      Class.forName("oracle.jdbc.driver.OracleDriver");
      String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
      String user = "";
      String pass = "";

      // establish connection to database 
      Connection con = DriverManager.getConnection(database, user, pass);
      Statement stmt = con.createStatement();

      // insert a single dataset into Fitnesszentrum

      try {
    String insertSql = "INSERT INTO Fitnesszentrum(abteilungsnr,name,plz,ort) VALUES ('1','FitInn', '1140', 'Wien')";
        stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
      }
        //Mitarbeiter
        for(int i=1; i<=2000; i++){
        try {
            String s= String.valueOf(i);
            int random_number4 = 1 + (int) (Math.random() * 28);
            int random_number2 = 0 + (int) (Math.random() * 40 + 1965);
            int random_number22 = 1 + (int) (Math.random() * 12);



            String insertSql = "INSERT INTO Mitarbeiter(Adresse, Geburtsdatum, LeiterMNr, AbteilungsNr) VALUES ('Adresse"+s+"','"+random_number4+"-FEB-"+random_number2+"', '1', '1')";
            stmt.executeUpdate(insertSql);
        } catch (Exception e) {
            System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
        }}
        
        
        //Personal_Trainer
        for(int i=1; i<=1000; i++){
            try {
                String m= String.valueOf(i);
              String insertSql = "INSERT INTO Personal_Trainer(mnr, trainerid, vorname, nachname) VALUES ("+m+","+m+", 'Vorname"+m+"','Nachname"+m+"')";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}
        
        //Rezeptionistin
        for(int i=1001; i<=2000; i++){
            try {
                int al = 9000+i;


                String l= String.valueOf(i);
                String insertSql = "INSERT INTO rezeptionistin(mnr, svnummer, email) VALUES ("+l+","+al+",'email"+l+"@gmail.com')";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}
        
        //Kunde
        for(int i=1; i<=1000; i++){
            try {
                String s= String.valueOf(i);
                int tel = 10000000+i;
                int trainer1 = 1 + (int) (Math.random() * 1000);

                
                
                String insertSql = "INSERT INTO kunde(kundennr, adresse, telefonnummer, abteilungsnr, trainerid) VALUES ("+s+",'Adresse"+s+"',"+tel+",'1',"+trainer1+")";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}
        
        String[] kabine = {"f", "m"};
        
        //kabine
        for(int i=1; i<=1000; i++){
            try {
                String s= String.valueOf(i);
                String insertSql = "INSERT INTO umkleidekabine(abteilungsnr, kabinenr, geschlecht) VALUES ('1',"+s+", '"+kabine[ (int) (Math.random() *2 )] +"')";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}
        
        //abo
        for(int i=1000; i<=2000; i++){
            try {
                int random_number4 = 1 + (int) (Math.random() * 28);
                int random_number2 = 0 + (int) (Math.random() * 3 + 2018);
                String m= String.valueOf(i);
                String insertSql = "INSERT INTO Abonnementstyp(abonr, kuendigungsfrist, geschaeftsbedingunden) VALUES ("+m+",'"+random_number4+"-FEB-"+random_number2+"', 'Etwas"+m+"')";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}
        
        //verkauf
        for(int i=1; i<1000; i++){
            try {
                int tausend = i+999;
                int al = 10000+i;

                String m= String.valueOf(i);
                String insertSql = "INSERT INTO verkauf(abonr, kundennr, svnummer) VALUES ("+tausend+","+m+","+al+")";
                stmt.executeUpdate(insertSql);
            } catch (Exception e) {
                System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
            }}


      // check number of datasets in person table
      ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM Fitnesszentrum");
      if (rs.next()) {
        int count = rs.getInt(1);
        System.out.println("Number of Fitnesszentrum: " + count);
      }
        // check number of datasets in person table
        ResultSet rk = stmt.executeQuery("SELECT COUNT(*) FROM Mitarbeiter");
        if (rk.next()) {
            int count1 = rk.getInt(1);
            System.out.println("Number of Mitarbeiter: " + count1);
        }
        
        // check number of datasets in person table
        ResultSet rl = stmt.executeQuery("SELECT COUNT(*) FROM Personal_Trainer");
        if (rl.next()) {
            int count2 = rl.getInt(1);
            System.out.println("Number of Trainers: " + count2);
        }
        
        // check number of datasets in person table
        ResultSet rf = stmt.executeQuery("SELECT COUNT(*) FROM Rezeptionistin");
        if (rf.next()) {
            int count3 = rf.getInt(1);
            System.out.println("Number of Rezeptionistinnen: " + count3);
        }
        // check number of datasets in person table
        ResultSet ro = stmt.executeQuery("SELECT COUNT(*) FROM Kunde");
        if (ro.next()) {
            int count4 = ro.getInt(1);
            System.out.println("Number of Kunden: " + count4);
        }
        // check number of datasets in person table
        ResultSet ri = stmt.executeQuery("SELECT COUNT(*) FROM Umkleidekabine");
        if (ri.next()) {
            int count5 = ri.getInt(1);
            System.out.println("Number of Kabinen: " + count5);
        }
        // check number of datasets in person table
        ResultSet rss = stmt.executeQuery("SELECT COUNT(*) FROM Abonnementstyp");
        if (rss.next()) {
            int count6 = rss.getInt(1);
            System.out.println("Number of Abos: " + count6);
        }
        // check number of datasets in person table
        ResultSet rs1 = stmt.executeQuery("SELECT COUNT(*) FROM Verkauf");
        if (rs1.next()) {
            int count7 = rs1.getInt(1);
            System.out.println("Number of Verkaeufe: " + count7);
        }


      // clean up connections
      rs.close();
        rk.close();
        rl.close();
        rf.close();
        ro.close();
        ri.close();
        rss.close();
        rs1.close();


      stmt.close();
      con.close();

    } catch (Exception e) {
      System.err.println(e.getMessage());
    }
  }
}
