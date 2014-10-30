package be.brainify.Kot_Nekted;


import android.support.v4.app.Fragment;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import com.facebook.*;
import com.facebook.model.GraphUser;
import com.facebook.widget.ProfilePictureView;

/**
 * Created by Nico on 18/10/14.
 */
public class ProfileFragment extends Fragment {

    public static final String TAG = "ProfileFragment";


    private Session.StatusCallback statusCallback;

    public ProfileFragment(){}
    UiLifecycleHelper uiHelper;
    ImageView imgAvatar;
    ImageView icnLayout;

    private TextView userNameView;
    private ProfilePictureView profilePictureView;
    private GraphUser pendingUpdateForUser;



    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        uiHelper.onActivityResult(requestCode, resultCode, data);
    }

    @Override
    public void onResume() {
        super.onResume();
        uiHelper.onResume();
    }


    @Override
    public void onPause() {
        super.onPause();
        uiHelper.onPause();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        uiHelper.onDestroy();
    }

    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        uiHelper.onSaveInstanceState(outState);
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View rootView = inflater.inflate(R.layout.fragment_profile,container,false);

        imgAvatar = (ImageView)rootView.findViewById(R.id.imgAvatar);
        icnLayout = (ImageView)rootView.findViewById(R.id.iconLayout);
        userNameView = (TextView)rootView.findViewById(R.id.tvName);

        if (pendingUpdateForUser != null) {
            updateViewForUser(pendingUpdateForUser);
            pendingUpdateForUser = null;
        }

   /*     Session.openActiveSession(getActivity(), true, new Session.StatusCallback() {

            // callback when session changes state
            @Override
            public void call(Session session, SessionState state, Exception exception) {

                if (session.isOpened()) {
                    // make request to the /me API
                    Request.newMeRequest(session, new Request.GraphUserCallback() {

                        // callback after Graph API response with user object
                        @Override
                        public void onCompleted(GraphUser user, Response response) {
                            if(user != null){
                                userNameView.setText(user.getName());
                            }
                        }
                    }).executeAsync();
                }else if (state.isClosed()){
                    userNameView.setText("Facebook Session closed\n");
                }else if(session.equals(SessionState.CLOSED_LOGIN_FAILED)){
                    userNameView.setText(state.toString());
                }else if(session.equals(SessionState.OPENING)){
                    userNameView.setText(state.toString());
                }else{
                    Session.openActiveSession(getActivity(), true,
                            statusCallback);
                    userNameView.setText(state.toString());
                }
            }
        });
*/

        return rootView;
    }
    public void updateViewForUser(GraphUser user) {
        if (userNameView == null || profilePictureView == null || !isAdded()) {
            // Fragment not yet added to the view. So let's store which user was intended
            // for display.
            pendingUpdateForUser = user;
            return;
        }

        if (user == null) {
            profilePictureView.setProfileId(null);
            userNameView.setText("Bonjours Personne");
        } else {
            profilePictureView.setProfileId(user.getId());
            userNameView.setText(
                    String.format(getString(R.string.greeting_format), user.getFirstName()));
        }
    }
}
