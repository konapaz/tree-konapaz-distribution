# tree-konapaz-distribution
Distributed Leaf Nodes Results of Unbalanced and No Binary Tree

https://github.com/konapaz/tree-konapaz-distribution


Assume We have a Tree (Not necessarily Βinary -or Balanced- Tree)

We want to get a list of its Leafs but not in standard way like pre-order post-order in-order ( https://en.wikipedia.org/wiki/Tree_traversal ) 
We want a balanced-circular order from the top to the bottom Parents Node and get only the Leafs into results, so recursive standard algorithms cannot be Applied.

For example, from the tree of the picture https://github.com/konapaz/tree-konapaz-distribution/blob/master/tree-konapaz-distribution.png we want to give balanced priority for each level Node (Started from Level 1, Nodes with k=1,7,9) So we get the first one Leaf from Node(k=1) then from Node(k=7) and then from Node(k=9) (where Leafs exists in sub-tree). Over and Over again (in Circular terms 1,7,9,1,7,9... ... 1,7,9) until we get all Leafs of the tree.
The same Rule should be Applied to all Node's Levels 2,3,4,5... Until we reach the Leaf's Level. 
Note we don't want to apply the circular rule to the Leaf's Level.

In this example all the Rules will by Applied for Level 1 and Level 2
Level 1: Nodes with k=1,7,9
Level 2: Nodes with k=2,5,8 OR k=11 OR k=14,16 when its turn came from its Parent balanced-order

So the expected results should be:

N(k=0) -> Ν(k=1) -> N(k=2) -> L(k=3)

N(k=0) -> Ν(k=7) -> N(k=8) -> L(k=9)

N(k=0) -> Ν(k=9) -> N(k=11) -> L(k=12)

--------------------------------------

N(k=0) -> Ν(k=1) -> N(k=5) -> L(k=6) 

N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!> 

N(k=0) -> Ν(k=9) -> N(k=14) -> L(k=15)

--------------------------------------

N(k=0) -> Ν(k=1) -> N(k=2) -> L(k=4)

N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>

N(k=0) -> Ν(k=9) -> N(k=16) -> L(k=17)

--------------------------------------

N(k=0) -> Ν(k=1) -> N(k=5) -> <No any other Leaf!>

N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>

N(k=0) -> Ν(k=9) -> N(k=11) -> L(k=13)

--------------------------------------

N(k=0) -> Ν(k=1) -> N(k=2) -> <No any other Leaf!>

N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>

N(k=0) -> Ν(k=9) -> N(k=14) -> <No any other Leaf!>

--------------------------------------

N(k=0) -> Ν(k=1) -> N(k=5) -> <No any other Leaf!>

N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>

N(k=0) -> Ν(k=9) -> N(k=16) -> L(k=18)

--------------------------------------

No more Iterator of Recursive search required because we got all Nine Leaf Nodes! 
Final results it should be a list with nodes key:

3,9,12,6,15,4,17,13,18

--------------------------------------
PS:
No matter how weird it may seem to you... I needed this code for a special merchant client! :)
