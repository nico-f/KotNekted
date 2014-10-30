package be.brainify.Kot_Nekted;

import android.support.v4.app.Fragment;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.*;
import org.w3c.dom.Text;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;


/**
 * Created by Nico on 18/10/14.
 */
public class ActivitiesFragment extends Fragment{

    public static final String TAG = "ActivitiesFragment";

    public String response;
    private int count = 0;
    private InputMethodManager imm = null;

    EditText ipAddress;
    Button btnPing;
    TextView reqOutput;
    ImageView imgKot;
    LinearLayout checkReq;
    public ActivitiesFragment(){}

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
        View rootView = inflater.inflate(R.layout.fragment_activities,container,false);

        imm = (InputMethodManager) getActivity().getSystemService(Context.INPUT_METHOD_SERVICE);

        ipAddress = (EditText)rootView.findViewById(R.id.etPing);
        btnPing = (Button)rootView.findViewById(R.id.btnPing);
        reqOutput = (TextView)rootView.findViewById(R.id.tvResponse);
        imgKot = (ImageView)rootView.findViewById(R.id.imgKot);
        checkReq = (LinearLayout)rootView.findViewById(R.id.checkReq);


        btnPing.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ipAddress.clearComposingText();
                ipAddress.clearFocus();
                count = 0;

                imm.hideSoftInputFromWindow(getView().getWindowToken(), 0);
                checkReq.setVisibility(View.GONE);
                imgKot.setVisibility(View.VISIBLE);
                reqOutput.setVisibility(View.INVISIBLE);
                try {
                    Process process = null;


                    if(Build.VERSION.SDK_INT <= 16) {
                        // shiny APIS
                        process = Runtime.getRuntime().exec(
                                "/system/bin/ping -n 4 " + ipAddress.getText().toString());
                    }
                    else
                    {
                        process = new ProcessBuilder()
                                .command("/system/bin/ping", ipAddress.getText().toString())
                                .redirectErrorStream(true)
                                .start();
                    }

                    BufferedReader reader = new BufferedReader(new InputStreamReader(
                            process.getInputStream()));

                    StringBuffer output = new StringBuffer();
                    String temp;

                    while ( ((temp = reader.readLine()) != null) && count < 4)//.read(buffer)) > 0)
                    {
                        output.append(count+1+" : ");
                        output.append(temp);
                        output.append("\n");
                        count++;
                    }

                    reader.close();


                    response = output.toString();
                    process.destroy();
                } catch (IOException e) {
                    e.printStackTrace();
                    checkReq.setBackgroundColor(getResources().getColor(R.color.error_color));
                }
                if(count > 2){
                    checkReq.setBackgroundColor(getResources().getColor(R.color.correct_color));
                }else{
                    checkReq.setBackgroundColor(getResources().getColor(R.color.error_color));
                }
                reqOutput.setText(response);
                imgKot.setVisibility(View.GONE);
                reqOutput.setVisibility(View.VISIBLE);
                checkReq.setVisibility(View.VISIBLE);

            }
        });



        return rootView;
    }
}
