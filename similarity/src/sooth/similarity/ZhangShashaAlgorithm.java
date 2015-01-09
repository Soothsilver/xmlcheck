package sooth.similarity;

import org.omg.CORBA.PRIVATE_MEMBER;

/**
 * This test returns the number of tree edit operations that must be performed on a tree to transform it into the other tree.
 *
 * This algorithm is introduced in the article "Simple fast algorithms for the editing distance between trees and related problems"
 * by Kaizhong Zhang and Dennis Shasha. It uses dynamic programming to find the minimum edit script using the operations
 * "insert a node", "delete a node" and "relabel a node".
 *
 * Time complexity: O(m*n*min(depth(T1), leaves(T1))*min(depth(T2), leaves(T2)).
 * Worst case time complexity is therefore: O(m*m*n*n)
 * Space complexity: O(m*n)
 */
public class ZhangShashaAlgorithm {

    public static final int DELETION_COST = 1;
    public static final int INSERTION_COST = 1;
    public static final int RELABEL_COST = 1;

    private int[][] treedist = new int[1][1];
    private int[][] forestdist= new int[1][1];
    private ZhangShashaTree firstTree;
    private ZhangShashaTree secondTree;

    /**
     * Compares two labeled ordered trees and returns their Zhang-Shasha tree edit distance.
     *
     * @param one The first tree.
     * @param two The second tree.
     * @return The tree edit distance.
     */
    public int compare(ZhangShashaTree one, ZhangShashaTree two) {
        if (treedist.length <= one.getNodeCount() || treedist.length <= two.getNodeCount())
        {
            int higherNodeCount = Math.max(one.getNodeCount(), two.getNodeCount()) + 1;
            treedist = new int[higherNodeCount][higherNodeCount];
            forestdist = new int[higherNodeCount][higherNodeCount];
        }

        firstTree = one;
        secondTree = two;

        for(int i : one.keyroots)
        {
            for (int j : two.keyroots)
            {
                calculateTreeDist(i+1, j+1);
            }
        }

        return treedist[one.getNodeCount()][two.getNodeCount()];
    }

    private void calculateTreeDist(int iMajor, int jMajor) {
        forestdist[0][0] = 0;
        int li = firstTree.nodes.get(iMajor-1).LeftmostLeaf + 1;
        int lj = secondTree.nodes.get(jMajor-1).LeftmostLeaf + 1;
        forestdist[li-1][0] = 0;
        forestdist[0][lj-1] = 0;
        for (int i = li; i <= iMajor; i++) {
            forestdist[i][0] = forestdist[i - 1][0] + DELETION_COST;
            forestdist[i][lj-1] = forestdist[i - 1][lj-1] + DELETION_COST;
        }
        for (int j = lj; j <= jMajor; j++) {
            forestdist[0][j] = forestdist[0][j-1] + INSERTION_COST;
            forestdist[li-1][j] = forestdist[li-1][j-1] + INSERTION_COST;
        }
        for (int i = li; i <= iMajor; i++) {
            for (int j = lj; j <= jMajor; j++) {
                int lSmallI = firstTree.nodes.get(i-1).LeftmostLeaf + 1;
                int lSmallJ = secondTree.nodes.get(j-1).LeftmostLeaf + 1;
                if (lSmallI == li && lSmallJ == lj) {
                    forestdist[i][j] = Math.min(
                      Math.min(
                              forestdist[i-1][j] + DELETION_COST,
                              forestdist[i][j-1] + INSERTION_COST
                      ),
                              forestdist[i-1][j-1] + (firstTree.nodes.get(i-1).Label.equals(secondTree.nodes.get(j-1).Label) ? 0 : RELABEL_COST)
                      );
                    treedist[i][j] = forestdist[i][j];

                } else {
                    forestdist[i][j] = Math.min(
                                forestdist[i-1][j] + DELETION_COST,
                            Math.min(
                                forestdist[i][j-1] + INSERTION_COST,
                                forestdist[lSmallI-1][lSmallJ-1] + treedist[i][j] // is calculation needed ?
                            )
                    );
                }
            }
        }
    }
}
