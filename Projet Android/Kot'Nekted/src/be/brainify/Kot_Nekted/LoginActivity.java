package be.brainify.Kot_Nekted;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.SystemClock;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Toast;
import be.brainify.Kot_Nekted.Application;
import be.brainify.Kot_Nekted.R;
import org.w3c.dom.Document;

import org.w3c.dom.Element;
import org.w3c.dom.NodeList;
import org.w3c.dom.Text;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.Objects;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

/**
 * Created by Nico on 24/11/14.
 */
public class LoginActivity extends FragmentActivity {

    private static final String TAG = "LoginActivity";
    private static final String urlXML = "http://kot-nekted.ddns.net/Symfony/web/mac/ip.xml";
    private static final String urlQR = "http://zxing.appspot.com/scan";
    public static boolean isLogged;

    private WifiManager wifiManager;
    private WifiInfo info;

    private static final ScheduledExecutorService worker = Executors.newSingleThreadScheduledExecutor();

    private Button toApp,toForm;
    private ImageView imgBrainToApp;
    private WebView qrScreen;
    public ProgressBar progBar;

    public Runnable hideProg;

    private Context ctx = this;
    private ArrayList<String> macs;

    private int nbKoters =0;

    public boolean isLogged() {
        return isLogged;
    }

    public void setLogged(boolean isLogged) {
        this.isLogged = isLogged;
    }

    public LoginActivity(){
        isLogged = false;
        ctx = this;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        toApp = (Button)findViewById(R.id.button);
        toForm = (Button)findViewById(R.id.button2);
        imgBrainToApp = (ImageView)findViewById(R.id.imageView);

        imgBrainToApp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent iApp = new Intent(ctx,Application.class);
                startActivity(iApp);
            }
        });

        toApp.setVisibility(View.GONE);
        toForm.setVisibility(View.GONE);
        progBar = (ProgressBar)findViewById(R.id.progressBar);
        qrScreen = (WebView)findViewById(R.id.webView);

        wifiManager = (WifiManager) getApplicationContext().getSystemService(WIFI_SERVICE);

        toApp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent iApp = new Intent(ctx,Application.class);
                startActivity(iApp);
            }
        });
        toForm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                qrScreen.setWebViewClient(new WebViewClient());
                qrScreen.getSettings().setJavaScriptEnabled(true);
                qrScreen.loadUrl(urlQR);
                qrScreen.setVisibility(View.VISIBLE);
                Toast.makeText(ctx,"Voici un lecteur de QRcode approprié",Toast.LENGTH_LONG);
            }
        });
        if(wifiManager.isWifiEnabled()) {
            info = wifiManager.getConnectionInfo();
            Toast.makeText(this, "Identification de votre téléphone", Toast.LENGTH_SHORT).show();
        } else {
            wifiManager.setWifiEnabled(true);
            Toast.makeText(this, "Nous avons activé votre Wi-Fi\nIdentification de votre téléphone", Toast.LENGTH_LONG).show();
            info = wifiManager.getConnectionInfo();
        }

        Log.i(TAG,"You're MAC is :" + info.getMacAddress());
        AsyncMacs myASTask = new AsyncMacs();
        new AsyncMacs().execute(urlXML,info.getMacAddress());
        //progBar.setVisibility(View.GONE);
        if(isLogged){
            Toast.makeText(this,"Welcome Home!" , Toast.LENGTH_LONG).show();
            Intent iApp = new Intent(ctx,Application.class);
            startActivity(iApp);
        }else{
            Runnable hideButton = new Runnable() {
                public void run() {
                    toForm.setVisibility(View.VISIBLE);
                }
            };
        worker.schedule(hideButton,0, TimeUnit.SECONDS);
        }
       hideProg = new Runnable() {
            public void run() {
                progBar.setVisibility(View.GONE);
            }
        };
}
class AsyncMacs extends AsyncTask<String,Void,Integer>{
    private static final String TAG = "AsyncMacs";

    public int nbKoters = 0;

    private LoginActivity backActivity = new LoginActivity();


    @Override
    protected void onPostExecute(Integer integer) {
        super.onPostExecute(integer);
        if(integer > 0){
            Toast.makeText(LoginActivity.this,"Il y a actuellement "+ nbKoters + " koter(s) à la maison" , Toast.LENGTH_SHORT).show();
        }else{
            Toast.makeText(LoginActivity.this,"Personne à la maison!", Toast.LENGTH_SHORT).show();
        }
        worker.schedule(hideProg,0, TimeUnit.MILLISECONDS);
    }

    //Arg1 : String URL
    //Arg2 : String MAC
    @Override
    protected Integer doInBackground(String... bundle) {
        try{
            getMainLooper().prepareMainLooper();
            getMainLooper().loop();
            URL url = new URL(bundle[0]);
            URLConnection conn = url.openConnection();
            DocumentBuilderFactory factory = DocumentBuilderFactory.newInstance();
            DocumentBuilder builder = factory.newDocumentBuilder();
            Document doc = builder.parse(conn.getInputStream());
            NodeList nodes = doc.getElementsByTagName("document");
            NodeList titles = nodes.item(0).getChildNodes();
            Log.i(TAG,titles.toString());
            for (int i = 0; i < titles.getLength(); i++) {
                if(titles.item(i) instanceof Element){
                    Element element = (Element) titles.item(i);
                    if(element.getAttribute("addrtype").equals("mac")){
                        nbKoters ++;
                        if(element.getAttribute("addr").equals(bundle[1])){
                            Log.i(TAG,"You're Mac has been matched\nYou'll be redirected");
                        }else{
                            Log.i(TAG, "You're MAC don't match\nPlease use this app in a KotNekted house!");
                        }
                        Log.i(TAG, "MAC : " + element.getAttribute("addr"));

                    }
                }
            }
        }catch(Exception e){
            e.printStackTrace();
            Log.i(TAG,bundle[0]+ "File access issues");
        }
        return nbKoters;
    }

    @Override
    protected void onPreExecute(){
        progBar.showContextMenu();
        super.onPreExecute();
    }


}
}
