package be.brainify.Kot_Nekted;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

/**
 * Created by Nico on 18/10/14.
 */
public class ExploreFragment extends Fragment {

    public static final String TAG = "ExploreFragment";

    public ExploreFragment(){}

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_explore,container,false);

        return rootView;
    }
}
