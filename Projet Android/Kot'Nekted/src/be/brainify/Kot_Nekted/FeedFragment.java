package be.brainify.Kot_Nekted;

import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import be.brainify.Kot_Nekted.adapter.FeedListAdapter;

import java.util.List;

/**
 * Created by Nico on 18/10/14.
 */
public class FeedFragment extends Fragment {

    public static final String TAG = "FeedFragment";

    private ListView listFeed;
    private FeedListAdapter feedAdapter;

   // public FeedFragment(){}

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_feed,container,false);
        listFeed = (ListView) rootView.findViewById(R.id.listView);
        feedAdapter = new FeedListAdapter(getActivity().getBaseContext());
        listFeed.setAdapter(feedAdapter);





        return rootView;
    }
}
