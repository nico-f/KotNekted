package be.brainify.Kot_Nekted.adapter;

import android.content.Context;
import android.content.res.Resources;
import android.media.Image;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import be.brainify.Kot_Nekted.R;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 * Created by Nico on 25/11/14.
 */
public class FeedListAdapter extends BaseAdapter {
    //SimpleDateFormat("dd.MM HH:mm");
    ArrayList<SingleRowFeed> list;
    public Context context;
    public FeedListAdapter(Context c){
        context = c;
        list = new ArrayList<SingleRowFeed>();
        Resources res = c.getResources();
        String[] names = res.getStringArray(R.array.Noms);
        String[] descs = res.getStringArray(R.array.Descriptions);
        String[] dates = res.getStringArray(R.array.DateTimes);
        int[] images = {R.drawable.img_ppl_check,R.drawable.img_ppl_down,R.drawable.img_ppl_in,R.drawable.img_ppl_left,R.drawable.img_ppl_look,R.drawable.img_ppl_right};
        for(int i =0;i<6;i++){
           list.add(new SingleRowFeed(dates[i],names[i],descs[i],images[i]));
        }
    }
    @Override
    public int getCount() {
        return list.size();
    }

    @Override
    public Object getItem(int position) {
        return list.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View row = inflater.inflate(R.layout.list_item_feed,parent,false);

        TextView name = (TextView) row.findViewById(R.id.textViewCreator);
        TextView desc = (TextView) row.findViewById(R.id.textViewDesc);
        TextView date = (TextView) row.findViewById(R.id.textViewDate);
        ImageView image = (ImageView) row.findViewById(R.id.imageView);

        SingleRowFeed temp = list.get(position);

        name.setText(temp.nom);
        desc.setText(temp.description);
        date.setText(temp.date);
        image.setImageResource(temp.image);

        return row;
    }
}
class SingleRowFeed{
    String date;
    String nom;
    String description;
    int image;

    SingleRowFeed(String d,String n,String desc,int img){
        this.date = d;
        this.nom = n;
        this.description = desc;
        this.image = img;
    }
}
