package sooth;

public class EntryPoint {
    public static void main(String[] args) {
        /*
            arguments are:
            1. action to be performed
             makeAll: delete all old similarity data, then create it anew (from source ZIP files)
             deleteAll: delete all old similarity data in database
             recheckAll: perform all comparisons from database again (but do not reload ZIP files)
             makeOne [id]: delete similarity data relating to submission [id], then reload it from ZIP files and check its similarity
             compare [id1] [id2]: do a direct comparison between two submissions
            2,3. parameters of this action
         */
    }
}
