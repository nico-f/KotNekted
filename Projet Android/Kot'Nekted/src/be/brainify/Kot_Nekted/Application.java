package be.brainify.Kot_Nekted;

import android.annotation.TargetApi;

import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;

import android.content.res.Configuration;
import android.content.res.TypedArray;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.ActionBarDrawerToggle;
import android.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.widget.DrawerLayout;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import android.widget.AdapterView;
import android.widget.ListView;

import be.brainify.Kot_Nekted.adapter.NavDrawerListAdapter;
import be.brainify.Kot_Nekted.modele.NavDrawerItem;
import com.facebook.Request;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.model.GraphUser;

import java.util.ArrayList;

/**
 * Created by Nico on 12/10/14.
 */
public class Application extends FragmentActivity {

        private static final String TOKEN_CACHE_NAME_KEY = "TokenCacheName";

        private KotFragment kotFragment;
        private FeedFragment feedFragment;
        private ActivitiesFragment activitiesFragment;
        private ExploreFragment exploreFragment;
        private ProfileFragment profileFragment;


        private boolean isShowingSettings;
        private Session currentSession;
        private Session.StatusCallback sessionStatusCallback;


        private DrawerLayout mDrawerLayout;
        private ListView mDrawerList;
        private ActionBarDrawerToggle mDrawerToggle;


        // nav drawer title
        private CharSequence mDrawerTitle;

        // used to store app title
        private CharSequence mTitle;

        // slide menu items
        private String[] navMenuTitles;
        private TypedArray navMenuIcons;

        private ArrayList<NavDrawerItem> navDrawerItems;
        private NavDrawerListAdapter adapter;

        @TargetApi(Build.VERSION_CODES.ICE_CREAM_SANDWICH)
        @Override
        protected void onCreate(Bundle savedInstanceState) {
            super.onCreate(savedInstanceState);
            setContentView(R.layout.activity_main);

            restoreFragments(savedInstanceState);

            mTitle = mDrawerTitle = getTitle();

            // load slide menu items
            navMenuTitles = getResources().getStringArray(R.array.nav_drawer_items);

            // nav drawer icons from resources
            navMenuIcons = getResources()
                    .obtainTypedArray(R.array.nav_drawer_icons);

            mDrawerLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
            mDrawerList = (ListView) findViewById(R.id.list_slidermenu);

            navDrawerItems = new ArrayList<NavDrawerItem>();

            // adding nav drawer items to array
            // Kot
            navDrawerItems.add(new NavDrawerItem(navMenuTitles[0], navMenuIcons.getResourceId(0, -1)));
            // Feed
            navDrawerItems.add(new NavDrawerItem(navMenuTitles[1], navMenuIcons.getResourceId(1, -1), true, "6"));
            // Activities
            navDrawerItems.add(new NavDrawerItem(navMenuTitles[2], navMenuIcons.getResourceId(2, -1)));
            // Explore
            navDrawerItems.add(new NavDrawerItem(navMenuTitles[3], navMenuIcons.getResourceId(3, -1)));
            // Settings
            navDrawerItems.add(new NavDrawerItem(navMenuTitles[4], navMenuIcons.getResourceId(4, -1)));


            mDrawerList.setOnItemClickListener(new SlideMenuClickListener());

            // Recycle the typed array
            navMenuIcons.recycle();

            // setting the nav drawer list adapter
            adapter = new NavDrawerListAdapter(getApplicationContext(),
                    navDrawerItems);
            mDrawerList.setAdapter(adapter);

            // enabling action bar app icon and behaving it as toggle button
            getActionBar().setDisplayHomeAsUpEnabled(true);
            getActionBar().setHomeButtonEnabled(true);

            mDrawerToggle = new ActionBarDrawerToggle(this, mDrawerLayout,
                    R.drawable.ic_drawer, //nav menu toggle icon
                    R.string.app_name, // nav drawer open - description for accessibility
                    R.string.app_name // nav drawer close - description for accessibility
            ){
                public void onDrawerClosed(View view) {
                    getActionBar().setTitle(mTitle);
                    // calling onPrepareOptionsMenu() to show action bar icons
                    invalidateOptionsMenu();
                }

                public void onDrawerOpened(View drawerView) {
                    getActionBar().setTitle(mDrawerTitle);
                    // calling onPrepareOptionsMenu() to hide action bar icons
                    invalidateOptionsMenu();
                }
            };
            mDrawerLayout.setDrawerListener(mDrawerToggle);

            if (savedInstanceState == null) {
                // on first time display view for first nav item
                displayView(0);
            }
        }

        /**
         * InterFragment communications save
         * */
        private void restoreFragments(Bundle savedInstanceState) {
            FragmentManager manager = getSupportFragmentManager();
            FragmentTransaction transaction = manager.beginTransaction();

            if (savedInstanceState != null) {
                kotFragment = (KotFragment)manager.getFragment(savedInstanceState,KotFragment.TAG);
                feedFragment = (FeedFragment)manager.getFragment(savedInstanceState,FeedFragment.TAG);
                activitiesFragment = (ActivitiesFragment)manager.getFragment(savedInstanceState,ActivitiesFragment.TAG);
                exploreFragment = (ExploreFragment)manager.getFragment(savedInstanceState,ExploreFragment.TAG);
                profileFragment = (ProfileFragment)manager.getFragment(savedInstanceState, ProfileFragment.TAG);
            }

            if (kotFragment == null) {
                kotFragment = new KotFragment();
                transaction.add(R.id.frame_container, kotFragment, KotFragment.TAG);
            }

            if (feedFragment == null) {
                feedFragment = new FeedFragment();
                transaction.add(R.id.frame_container, feedFragment, FeedFragment.TAG);
            }

            if (activitiesFragment == null) {
                activitiesFragment = new ActivitiesFragment();
                transaction.add(R.id.frame_container, activitiesFragment, ActivitiesFragment.TAG);
            }

            if (exploreFragment == null) {
                exploreFragment = new ExploreFragment();
                transaction.add(R.id.frame_container, exploreFragment, ExploreFragment.TAG);
            }

            if (profileFragment == null) {
                profileFragment = new ProfileFragment();
                transaction.add(R.id.frame_container, profileFragment, ProfileFragment.TAG);
            }

        transaction.commit();
    }
    private void fetchUserInfo() {
        if (currentSession != null && currentSession.isOpened()) {
            Request request = Request.newMeRequest(currentSession, new Request.GraphUserCallback() {
                @Override
                public void onCompleted(GraphUser me, Response response) {
                    if (response.getRequest().getSession() == currentSession) {
                        updateFragments(me);
                    }
                }
            });
            request.executeAsync();
        }
    }
    private void updateFragments(GraphUser user) {
        profileFragment.updateViewForUser(user);
    }
        /**
         * Slide menu item click listener
         * */
        private class SlideMenuClickListener implements ListView.OnItemClickListener {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position,
                                    long id) {
                // display view for selected nav drawer item
                displayView(position);
            }
        }

        /**
         * Diplaying fragment view for selected nav drawer list item
         * */
        private void displayView(int position) {
            // update the main content by replacing fragments
            android.support.v4.app.Fragment fragment = null;
            switch (position) {
                case 0:
                    fragment = new KotFragment();
                    break;
                case 1:
                    fragment = new FeedFragment();
                    break;
                case 2:
                    fragment = new ActivitiesFragment();
                    break;
                case 3:
                    fragment = new ExploreFragment();
                    break;
                case 4:
                    fragment = new ProfileFragment();
                    break;

                default:
                    break;
            }

            if (fragment != null) {
                FragmentManager fragmentManager = getSupportFragmentManager();
                fragmentManager.beginTransaction()
                        .replace(R.id.frame_container, fragment).commit();

                // update selected item and title, then close the drawer
                mDrawerList.setItemChecked(position, true);
                mDrawerList.setSelection(position);
                setTitle(navMenuTitles[position]);
                mDrawerLayout.closeDrawer(mDrawerList);
            } else {
                // error in creating fragment
                Log.e("MainActivity", "Error in creating fragment");
            }
        }

        @Override
        public boolean onCreateOptionsMenu(Menu menu) {
            getMenuInflater().inflate(R.menu.main, menu);
            return true;
        }

        @Override
        public boolean onOptionsItemSelected(MenuItem item) {
            // toggle nav drawer on selecting action bar app icon/title
            if (mDrawerToggle.onOptionsItemSelected(item)) {
                return true;
            }
            // Handle action bar actions click
            switch (item.getItemId()) {
                case R.id.action_settings:
                    return true;
                default:
                    return super.onOptionsItemSelected(item);
            }
        }

        /***
         * Called when invalidateOptionsMenu() is triggered
         */
        @Override
        public boolean onPrepareOptionsMenu(Menu menu) {
            // if nav drawer is opened, hide the action items
            boolean drawerOpen = mDrawerLayout.isDrawerOpen(mDrawerList);
            menu.findItem(R.id.action_settings).setVisible(!drawerOpen);
            return super.onPrepareOptionsMenu(menu);
        }

        @Override
        public void setTitle(CharSequence title) {
            mTitle = title;
            getActionBar().setTitle(mTitle);
        }

        /**
         * When using the ActionBarDrawerToggle, you must call it during
         * onPostCreate() and onConfigurationChanged()...
         */

        @Override
        protected void onPostCreate(Bundle savedInstanceState) {
            super.onPostCreate(savedInstanceState);
            // Sync the toggle state after onRestoreInstanceState has occurred.
            mDrawerToggle.syncState();
        }

        @Override
        public void onConfigurationChanged(Configuration newConfig) {
            super.onConfigurationChanged(newConfig);
            // Pass any configuration change to the drawer toggls
            mDrawerToggle.onConfigurationChanged(newConfig);

        }


}
