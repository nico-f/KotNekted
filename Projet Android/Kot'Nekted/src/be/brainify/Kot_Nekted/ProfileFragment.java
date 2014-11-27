package be.brainify.Kot_Nekted;


import android.graphics.Bitmap;
import android.location.*;
import android.net.Uri;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.Fragment;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;
import com.dropbox.client2.DropboxAPI;
import com.dropbox.client2.android.AndroidAuthSession;
import com.dropbox.client2.exception.DropboxException;
import com.facebook.*;
import com.facebook.model.GraphUser;
import com.facebook.widget.ProfilePictureView;

import java.io.*;
import java.net.Inet4Address;
import java.net.InetAddress;
import java.net.NetworkInterface;
import java.net.SocketException;
import java.util.Enumeration;
import java.util.List;

/**
 * Created by Nico on 18/10/14.
 */
public class ProfileFragment extends Fragment implements LocationListener {
    final int REQUEST_FROM_CAMERA=1;
    public static final String TAG = "ProfileFragment";

    private DropboxAPI<AndroidAuthSession> mDBApi;
    private LocationManager mgr;
    private String best;
    public static double myLocationLatitude;
    public static double myLocationLongitude;

    private Application myApp;

    public ProfileFragment(){}

    private TextView nickName,kotName,firstName,lastName,numPhone,password,ip,mac,coordLong,coordLat;
    public ImageView profilePictureView;
    private GraphUser pendingUpdateForUser;
    private WifiInfo info;
    private WifiManager wifiManager;
    private InetAddress ipAddress;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_profile,container,false);


        nickName = (TextView)rootView.findViewById(R.id.textView3);
        firstName = (TextView)rootView.findViewById(R.id.textView);
        lastName = (TextView)rootView.findViewById(R.id.textView5);
        kotName = (TextView)rootView.findViewById(R.id.textView2);
        numPhone = (TextView)rootView.findViewById(R.id.textView6);
        password = (TextView)rootView.findViewById(R.id.textView7);
        ip = (TextView)rootView.findViewById(R.id.textView8);
        mac = (TextView)rootView.findViewById(R.id.textView9);
        coordLat = (TextView)rootView.findViewById(R.id.textView10);
        coordLong = (TextView)rootView.findViewById(R.id.textView11);
        profilePictureView = (ImageView)rootView.findViewById(R.id.imageView);

        profilePictureView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               getPhotoClick();
            }
        });

        mgr = (LocationManager) getActivity().getSystemService(getActivity().LOCATION_SERVICE);
        wifiManager = (WifiManager) getActivity().getSystemService(getActivity().WIFI_SERVICE);

        updateProviders();

        Criteria criteria = new Criteria();

        best = mgr.getBestProvider(criteria, true);
        Log.d("best provider", best);

        Location location = mgr.getLastKnownLocation(best);
        updateLocation(location);

        if(wifiManager.isWifiEnabled()) {
            info = wifiManager.getConnectionInfo();
        } else {
            wifiManager.setWifiEnabled(true);
            Toast.makeText(getActivity(),"We've activated your Wi-fi", Toast.LENGTH_SHORT).show();
            info = wifiManager.getConnectionInfo();
        }
            ip.setText(getIpAddress());
            mac.setText(info.getMacAddress());
            coordLat.setText(Double.toString(myLocationLatitude));
            coordLong.setText(Double.toString(myLocationLongitude));

        return rootView;
    }
    public void getPhotoClick()
    {
        Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        intent.putExtra(MediaStore.EXTRA_OUTPUT,Uri.fromFile(new File(Environment.getExternalStorageDirectory(),"image.tmp")));
        startActivityForResult(intent, 1);
    }
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == REQUEST_FROM_CAMERA && resultCode == getActivity().RESULT_OK) {
            Bundle extras = data.getExtras();
            Bitmap imageBitmap = (Bitmap) extras.get("data");
            profilePictureView.setImageBitmap(imageBitmap);
        }
    }
    public static String getIpAddress() {
        try {
            for (Enumeration en = NetworkInterface.getNetworkInterfaces(); en.hasMoreElements();) {
                NetworkInterface intf = (NetworkInterface)en.nextElement();
                for (Enumeration enumIpAddr = intf.getInetAddresses(); enumIpAddr.hasMoreElements();) {
                    InetAddress inetAddress = (InetAddress)enumIpAddr.nextElement();
                    if (!inetAddress.isLoopbackAddress()&&inetAddress instanceof Inet4Address) {
                        String ipAddress=inetAddress.getHostAddress();
                        Log.e("IP address", "" + ipAddress);
                        return ipAddress;
                    }
                }
            }
        } catch (SocketException ex) {
            Log.e("Socket exception in GetIP Address of Utilities", ex.toString());
        }
        return null;
    }

    private void updateLocation(Location l) {

        if (l == null) {

            myLocationLatitude = 0.0;
            myLocationLongitude = 0.0;
        } else {

            myLocationLatitude = l.getLatitude();
            myLocationLongitude = l.getLongitude();
            coordLat.setText(Double.toString(myLocationLatitude));
            coordLong.setText(Double.toString(myLocationLongitude));
        }
    }

    private void updateProviders() {

        List<String> providers = mgr.getAllProviders();
        for (String p : providers) {

            updateProviders(p);
        }
    }

    private void updateProviders(String s) {

        LocationProvider info = mgr.getProvider(s);
        StringBuilder builder = new StringBuilder();
        builder.append("name: ").append(info.getName());
    }
    @Override
    public void onPause() {

        super.onPause();
        mgr.removeUpdates(this);
    }

    @Override
    public void onResume() {

        super.onResume();
        mgr.requestLocationUpdates(best, 15000, 1, this);
    }

    @Override
    public void onLocationChanged(Location location) {
        updateLocation(location);
    }

    @Override
    public void onStatusChanged(String provider, int status, Bundle extras) {

    }

    @Override
    public void onProviderEnabled(String provider) {

    }

    @Override
    public void onProviderDisabled(String provider) {

    }

    public boolean uploadFile(String path,String dest){
        File file = new File(path);
        FileInputStream inputStream = null;
        try {
            inputStream = new FileInputStream(file);
        } catch (FileNotFoundException e) {
            e.printStackTrace();
            return false;
        }
        DropboxAPI.Entry response = null;
        try {
            response = mDBApi.putFile(dest, inputStream,
                    file.length(), null, null);
        } catch (DropboxException e) {
            e.printStackTrace();
            return false;
        }
        Log.i("DbExampleLog", "The uploaded file's rev is: " + response.rev);
        return true;
    }
    public boolean downloadFile(String path,String dest){
        File file = new File(dest);
        FileOutputStream outputStream = null;
        try {
            outputStream = new FileOutputStream(file);
        } catch (FileNotFoundException e) {
            e.printStackTrace();
            return false;
        }
        DropboxAPI.DropboxFileInfo info = null;
        try {
            info = mDBApi.getFile(path, null, outputStream, null);
        } catch (DropboxException e) {
            e.printStackTrace();
            return false;
        }
        Log.i("DbExampleLog", "The file's rev is: " + info.getMetadata().rev);
        return true;
    }
}
