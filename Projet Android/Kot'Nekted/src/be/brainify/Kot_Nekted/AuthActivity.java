package be.brainify.Kot_Nekted;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.widget.Toast;
import com.dropbox.client2.DropboxAPI;
import com.dropbox.client2.android.AndroidAuthSession;
import com.dropbox.client2.exception.DropboxException;
import com.dropbox.client2.session.AppKeyPair;
import com.dropbox.client2.session.Session;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;

/**
 * Created by Nico on 24/11/14.
 */
public class AuthActivity extends Activity {

    private DropboxAPI<AndroidAuthSession> mDBApi;


    final static private String APP_KEY = "h2ndsgy8z77imfl";
    final static private String APP_SECRET = "6n059e4h1ynek6s";
    final static private com.dropbox.client2.session.Session.AccessType ACCESS_TYPE = Session.AccessType.DROPBOX;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        AppKeyPair appKeys = new AppKeyPair(APP_KEY, APP_SECRET);
        AndroidAuthSession session = new AndroidAuthSession(appKeys, ACCESS_TYPE);
        mDBApi = new DropboxAPI<AndroidAuthSession>(session);

        mDBApi.getSession().startOAuth2Authentication(getApplication());


    }
    protected void onResume() {
        super.onResume();
        Boolean received = false;
        if (mDBApi.getSession().authenticationSuccessful()) {
            try {
                // Required to complete auth, sets the access token on the session
                new Thread(new Runnable() {
                    public void run() {
                        mDBApi.getSession().finishAuthentication();
                        String accessToken = mDBApi.getSession().getOAuth2AccessToken();
                        File file = new File(getExternalFilesDir(null), "ip.xml");
                        FileOutputStream outputStream = null;
                        try {
                            outputStream = new FileOutputStream(file);
                        } catch (FileNotFoundException e) {
                            e.printStackTrace();
                        }
                        DropboxAPI.DropboxFileInfo info = null;
                        try {
                            info = mDBApi.getFile("ip.xml", null, outputStream, null);
                        } catch (DropboxException e) {
                            e.printStackTrace();
                            Log.e("DbExampleLog", "The file hasn't been recovered");
                        }
                        Log.i("DbExampleLog", "The file's rev is: " + (info.getMetadata().fileName() + ": " +info.getMetadata().size));

                    }

                }).start();
            } catch (IllegalStateException e) {
                Log.i("DbAuthLog", "Error authenticating", e);

            }
        }
    }
}
