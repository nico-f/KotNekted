package be.brainify.Kot_Nekted;

import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.util.Log;
import android.widget.Toast;

/**
 * Created by Nico on 4/12/14.
 */
public class Utils {


        private static final String TAG = Utils.class.getName();

        public static boolean isFreeScannerAppInstalled(Context ctx) {
            return isIntentAvailable(ctx, Scan.ACTION);
        }

        public static boolean isProScannerAppInstalled(Context ctx) {
            return isIntentAvailable(ctx, Scan.Pro.ACTION);
        }

        public static void launchMarketToInstallFreeScannerApp(Context ctx) {
            launchMarketToInstallApp(ctx, Scan.PACKAGE);
        }

        public static void launchMarketToInstallProScannerApp(Context ctx) {
            launchMarketToInstallApp(ctx, Scan.Pro.PACKAGE);
        }

        private static boolean isIntentAvailable(Context ctx, String action) {
            Intent test = new Intent(action);
            return ctx.getPackageManager().resolveActivity(test, 0) != null;
        }

        public static void launchMarketToInstallApp(Context ctx, String pkgName) {
            try {
                Intent intent = new Intent(Intent.ACTION_VIEW,
                        Uri.parse("market://details?id=" + pkgName));
                ctx.startActivity(intent);
            } catch (ActivityNotFoundException e) {
                Log.e(TAG, "Android Market aka Play Market not installed.", e);
                Toast.makeText(ctx, "Erreur !", Toast.LENGTH_SHORT).show();
            }
        }

        private Utils() {
        }

    }
