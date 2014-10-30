package be.brainify.Kot_Nekted;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * Created by Nico on 18/10/14.
 */
public class FeedFragment extends Fragment {

    public static final String TAG = "FeedFragment";

    public FeedFragment(){}

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_feed,container,false);

        return rootView;
    }
}
