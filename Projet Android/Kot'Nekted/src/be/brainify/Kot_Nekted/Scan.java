package be.brainify.Kot_Nekted;

/**
 * Created by Nico on 4/12/14.
 */
public class Scan {
        /**
         * When a barcode is read, pic2shop returns Activity.RESULT_OK in
         * onActivityResult() of the activity which requested the scan using
         * startActivityForResult(). The read barcode can be retrieved with
         * intent.getStringExtra(BARCODE).<br>
         * If the user exits pic2shop by pressing Back before a barcode is read, the
         * result code will be Activity.RESULT_CANCELED in onActivityResult().
         */

        public static final String PACKAGE = "be.brainify.Kot_Nekted";
        public static final String ACTION = PACKAGE + ".SCAN";
        // response Intent
        public static final String BARCODE = "BARCODE";

        public static interface Pro {

            public static final String PACKAGE = "com.visionsmarts.pic2shoppro";
            public static final String ACTION = PACKAGE + ".SCAN";

            // request Intent
            public static final String FORMATS = "formats";
            // response Intent
            public static final String FORMAT = "format";
        }

        private Scan() {
        }
    }
