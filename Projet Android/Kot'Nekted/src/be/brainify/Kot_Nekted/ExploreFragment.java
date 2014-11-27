package be.brainify.Kot_Nekted;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageView;

/**
 * Created by Nico on 18/10/14.
 */
public class ExploreFragment extends Fragment {
    //Copy Paste from Kot's Fragment
    public static final String TAG = "ExploreFragment";
    public static final String url = "http://kot-nekted.ddns.net/Symfony/web/app.php/who";

    public ExploreFragment(){}
    private WebView kotScreen;
    private ImageView icnLayout;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_explore,container,false);

        kotScreen =(WebView)rootView.findViewById(R.id.webView);
        icnLayout = (ImageView)rootView.findViewById(R.id.icnLayout);

        kotScreen.setWebViewClient(new WebViewClient());
        kotScreen.getSettings().setJavaScriptEnabled(true);
        kotScreen.loadUrl(url);
        icnLayout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                icnLayout.setVisibility(View.GONE);
                kotScreen.setVisibility(View.VISIBLE);
            }});
        return rootView;
    }
}

