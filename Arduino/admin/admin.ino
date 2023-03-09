#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include "Adafruit_Keypad.h"

#define RST_PIN 4
#define SS_PIN  5

//SUHU && LCD
//SDA - G21
//SCL - G22
//
//RFID
//RST - G4
//MISO - G19
//MOSI - G23
//SDA - G5
//SCK - G18
//
//IR
//OUT - G25
//
//BUTTON
//1 - G26
//2 - G27
//
//BUZZ
//+ - G0

const byte ROWS = 4; // rows
const byte COLS = 4; // columns
//define the symbols on the buttons of the keypads
char keys[ROWS][COLS] = {
  {'1','2','3','A'},
  {'4','5','6','B'},
  {'7','8','9','C'},
  {'*','0','#','D'}
};
byte rowPins[ROWS] = {32, 33, 12, 14};   //connect to the row pinouts of the keypad
byte colPins[COLS] = {17, 16, 2, 15}; //connect to the column pinouts of the keypad

//initialize an instance of class NewKeypad
Adafruit_Keypad customKeypad = Adafruit_Keypad( makeKeymap(keys), rowPins, colPins, ROWS, COLS);
char keyPressed;
//char password[] = "AAAAA";
char inputPassword[5];
int no = 0;

String pw;


MFRC522 mfrc522(SS_PIN, RST_PIN);
LiquidCrystal_I2C lcd (0x27, 16, 2);

int Led_OnBoard = 2;
const int buzz = 0;
const int btn1 = 27;
const int btn2 = 26;
const int btn3 = 25;
int button1;
int button2;
int button3;

bool quit = 0;
String iData1 = "22";
String iData2 = "2";
String iData3 = "3";
String iData4 = "36";

float temp;
String stats = "";
String sendMode = "checkRFIDUser";
String postData;
String Data1;
String Data2;
String Data3;
String Data4;

//String host = "192.168.0.103";
//String host = "192.168.43.160";
//String host = "testingstarproject.000webhostapp.com";
//String host = "wirapustaka.ninapst.com";
//String host = "rizalscompanylab.my.id";
String host = "function.rizalscompanylab.my.id";
//String host = "192.168.100.169";

const char* ssid = "STAR";
const char* password = "skansawira";

//const char* ssid = "LAB TITL";
//const char* password = "titlsuksesselalu";

//const char* ssid = "LIMITED";
//const char* password = "12344321";

//String url = "http://" + host + "/Krenova/GitFolder/Peminjaman-Buku-1/PHP/admin/fungsiAdmin.php";
//String url = "https://" + host + "/index.php";
//String url = "http://" + host + "/admin/fungsiAdmin.php";
//String url = "http://" + host + "/Project_SmartBoardingSchool/finalProject/dist/function/function.php";
//String url = "https://" + host + "/dist/function/function.php";
String url = "http://" + host + "/function.php";
String dataUpload[10];
String rfidUser;
String bayarPesanan;
String confirm;


void setup() {
  Serial.begin(115200);
  pinMode(btn1, INPUT_PULLUP);
  pinMode(btn2, INPUT_PULLUP);
  pinMode(btn3, INPUT_PULLUP);
  pinMode(Led_OnBoard, OUTPUT);
  pinMode(buzz, OUTPUT);
  SPI.begin();
  mfrc522.PCD_Init();
  lcd.init();
  lcd.backlight();
    customKeypad.begin();
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  Serial.print("Connecting to Wi-Fi");
  
  while (WiFi.status() != WL_CONNECTED) {
    lcd.setCursor (2,0);
    lcd.print("Connecting  ");
    delay(250);
    lcd.setCursor (2,0);
    lcd.print("Connecting. ");
    delay(250);
    lcd.setCursor (2,0);
    lcd.print("Connecting..");
    Serial.print(".");
    delay(250);
  }
  buzzer(2);
  Serial.println("OK.");
  Serial.println("Connected to Network/SSID");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
  digitalWrite(Led_OnBoard, HIGH);
  lcd.clear();
  lcd.setCursor (3,0);
  lcd.print("Connected");
  delay(500);
  lcd.clear();
  
}
void loop() {
  jalan();
  
}

String scann() {
  while ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    delay(50);
    
  }
  while ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    delay(50);
  }
  buzzer(1);
//  Serial.print("UID :");
  String guid;
  String content= "";
  byte letter;
  
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
//     Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
//     Serial.print(mfrc522.uid.uidByte[i], HEX);
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  
  Serial.println();
  content.toUpperCase();
  guid = content.substring(1);
  guid.replace(" ", "");
  return guid;
}

void jalan() {
  lcd.setCursor (1,0);
  lcd.print("BELUM ADA USER");
  lcd.setCursor (6,1);
  lcd.print("BARU");
  bayarPesanan = request(sendMode, iData1, "", "");
  if (bayarPesanan != "GAGAL") {
    lcd.clear();
    lcd.setCursor (3,0);
    lcd.print("TAMBAH RFID");
    lcd.setCursor (0,1);
    lcd.print(bayarPesanan);
    buzzer(1);
    while ( ! mfrc522.PICC_IsNewCardPresent() && ! mfrc522.PICC_ReadCardSerial()) {
      delay(100);
    }
    rfidUser = scann();
    Serial.println(rfidUser);
    sendMode = "addRFIDUser";
    confirm = request(sendMode, rfidUser, "", "");
    sendMode = "checkRFIDUser";
    if (confirm == "BERHASIL") {
      lcd.clear();
      lcd.setCursor (4,0);
      lcd.print("BERHASIL  ");
      lcd.setCursor (3,1);
      lcd.print("MENAMBAHKAN");
      
      buzzer(1);
      delay(1500);
      lcd.clear();
      
    } else {
       lcd.clear();
        lcd.setCursor (6,0);
        lcd.print("GAGAL");
        lcd.setCursor (3,1);
      lcd.print("MENAMBAHKAN");
        buzzer(5);
        delay(1500);
        lcd.clear();
    }
  } else {
    delay(1000);
    return;
    
  }
  
 
}

String request(String satu, String dua, String tiga, String empat) {
  HTTPClient http;
  Data1 = String(satu);
  Data2 = String(dua);
  Data3 = String(tiga);
  Data4 = String(empat);
 
  postData = "Data1=" + Data1 + "&Data2=" + Data2 + "&Data3=" + Data3 + "&Data=" + Data4 ;
  Serial.println(postData);
 
  http.begin(url);
  Serial.println(url);
  
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
//  lcd.clear();
//  lcd.setCursor (1,0);
//  lcd.print("MENGIRIM DATA");
  int httpCode = http.POST(postData);
  Serial.print("uploading");
  
  String payload = http.getString();
  
  Serial.println(httpCode);
  Serial.println(payload);
  if (httpCode != 200) {
    return "GAGAL";
  }
  String response = ambilData(payload, "status");
  
//  if (Data4 == "tambahBuku") {
//    lcd.clear();
//    lcd.setCursor (2,0);
//    lcd.print("TAMBAH BUKU");
//
//  }

//  if (response != "1" || response != "GAGAL") {
//    lcd.setCursor (1,1);
//    lcd.print(response);
//    buzzer(1);
//  } else {
//    lcd.setCursor (5,1);
//    lcd.print("GAGAL");
//    buzzer(5);
//  }
  
//  if (response == "BERHASIL") {
//    lcd.setCursor (1,1);
//    lcd.print("BERHASIL");
//    buzzer(1);
//  } else {
//    lcd.setCursor (5,1);
//    lcd.print("GAGAL");
//    buzzer(5);
//  }
  
  http.end();
//  delay(1000);
//  lcd.clear();
  return response;
}













void buzzer(int banyakLoop) {
//  digitalWrite(buzz, HIGH);
//  delay(100);
//  digitalWrite(buzz, LOW);
//  delay(100);
  for (int i = 1; i <= banyakLoop; i++) {
    digitalWrite(buzz, HIGH);
    delay(100);
    digitalWrite(buzz, LOW);
    delay(100); 
  }
}


String ambilData(String dataPayload, String varr) {
  String responseData = dataPayload;
  int responseDataStart = responseData.indexOf(String(varr)+":")+ varr.length() + 1;
//  Serial.println(responseDataStart);
  int responseDataEnd = responseDataStart + responseData.substring(responseDataStart).indexOf("|");
//  Serial.println(responseDataEnd);
  responseData = responseData.substring(responseDataStart,responseDataEnd);
//  Serial.println(responseData);
  return responseData;
}
