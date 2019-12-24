<?php
/* 
Assume We have a Tree (Not necessarily Βinary -or Balanced- Tree)

We want to get a list of its Leafs but not in standard way like pre-order post-order in-order ( https://en.wikipedia.org/wiki/Tree_traversal ) 
We want a balanced-circular order from the top to the bottom Parents Node and get only the Leafs into results, so recursive standard algorithms cannot be Applied.

For example, from the below tree we want to give balanced priority for each level Node (Started from Level 1, Nodes with k=1,7,9) So we get the first one Leaf from Node(k=1) then from Node(k=7) and then from Node(k=9) (where Leafs exists in sub-tree). Over and Over again (in Circular terms 1,7,9,1,7,9... ... 1,7,9) until we get all Leafs of the tree.
The same Rule should be Applied to all Node's Levels 2,3,4,5... Until we reach the Leaf's Level. 
Note we don't want to apply the circular rule to the Leaf's Level.

In this example all the Rules will by Applied for Level 1 and Level 2
Level 1: Nodes with k=1,7,9
Level 2: Nodes with k=2,5,8 OR k=11 OR k=14,16 when its turn came from its Parent balanced-order

So the expected results should be:

N(k=0) -> Ν(k=1) -> N(k=2) -> L(k=3)
N(k=0) -> Ν(k=7) -> N(k=8) -> L(k=9)
N(k=0) -> Ν(k=9) -> N(k=11) -> L(k=12)

N(k=0) -> Ν(k=1) -> N(k=5) -> L(k=6)
N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>
N(k=0) -> Ν(k=9) -> N(k=14) -> L(k=15)

N(k=0) -> Ν(k=1) -> N(k=2) -> L(k=4)
N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>
N(k=0) -> Ν(k=9) -> N(k=16) -> L(k=17)

N(k=0) -> Ν(k=1) -> N(k=5) -> <No any other Leaf!>
N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>
N(k=0) -> Ν(k=9) -> N(k=11) -> L(k=13)

N(k=0) -> Ν(k=1) -> N(k=2) -> <No any other Leaf!>
N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>
N(k=0) -> Ν(k=9) -> N(k=14) -> <No any other Leaf!>

N(k=0) -> Ν(k=1) -> N(k=5) -> <No any other Leaf!>
N(k=0) -> Ν(k=7) -> N(k=8) -> <No any other Leaf!>
N(k=0) -> Ν(k=9) -> N(k=16) -> L(k=18)

No more Iterator of Recursive search required because we got all Nine Leaf Nodes! 
Final results it should be a list with nodes key 3,9,12,6,15,4,17,13,18


Level 0:							    N(k=0) ---.
									   /|          \
									  / |           \	   
									 /  |            \	   
									/   |             \	   
								   /    |              \	   
								  /	    |               \   
								 /      |  	             \	
Level 1:					N(k=1)	N(k=7)		        N(k=9)
							 /\	   	  \				 /	   |    \
							/  \	   \			/	   |     \
						   /	\	    \		   /       |      \
Level 2:				N(k=2)	N(k=5)	N(k=8)	  N(k=11)  N(k=14) N(k=16) --------.
						 / \	   \	  \			|    \		 \		 \          \
						/   \	    \	   \		| 	  \		  \		  \	  		 \
Level 3:			L(k=3)	L(k=4)  L(k=6)	L(k=9) L(k=12) L(k=13) L(k=15) L(k=17)	L(k=18)

N = Node (as a Connection between other Nodes to reach the Leafs)
L = Leaf (Node as data-target Object)
k = any index to identify our nodes

*/


/*
We Build the Tree Structure and its necessary data to the algorithm
*/

/***** Tree initialization ****/
$key = 0;
$tree = [
		'index'=>0,
		'type'=>'node',
		'completed'=>false,
		'recursive'=>true,
		'list'=>[],
		'key'=>$key,
];

//each key is the count of before-last nodes, and its value is the leaf count nodes for each node
$random_c_nodes = [['c'=>2, 'lc'=>[2,1]],['c'=>1, 'lc'=>[1]],['c'=>3, 'lc'=>[2,1,2]]];



for ($a=0; $a<count($random_c_nodes); $a++) {
	//first level nodes initialization
	$key++;
	$tree['list'][$a] =
	[
		'index'=>0,
		'type'=>'node',
		'completed'=>false,
		'recursive'=>true, //is recursive, go deeper
		'list'=>[],
		'key'=>$key,
	];
	
	//second level nodes initialization
	$node_level_A = &$tree['list'][$a];
	$count_c = $random_c_nodes[$a]['c'];
	for ($c=0; $c<$count_c; $c++) {
		$key++;
		$node_level_A['list'][$c] = [
			'index'=>0,
			'type'=>'node',
			'completed'=>false,
			'recursive'=>false, //is last recursive node, stop recursive
			'list'=>[],
			'key'=>$key,
		];
		
		$node_level_B = &$node_level_A['list'][$c];
		$count_lc = $random_c_nodes[$a]['lc'][$c];

		for ($i=0; $i<$count_lc; $i++) {
			$key++;
			$node_level_B['list'][$i] = [
				'type'=>'leaf',
				'key'=>$key,
			];
		}
	}
}
/***** END Tree initialization ****/

/* 
DISPLAY Tree Info
echo '<pre>';
var_dump($tree);
echo '</pre>';
*/



/***** Algorithm Implementation ****/

class TreeKonapazDistribution {
	
	public static function getCountLeaf($node) {
		if ($node['type'] == 'leaf') {
			return 1;
		}
		
		$count = 0;
		if ($node['type'] == 'node') {
			foreach ($node['list'] as $node):
				$count += self::getCountLeaf($node);
			endforeach;
		}
		return $count;
	}
	
	
	public static function getDistributedLeaf($tree) {
		$list = [];
		$final_counts = self::getCountLeaf($tree);
		while (count($list) < $final_counts) {
			$tmp = self::getNextLeafNode($tree);
			if ($tmp) {
				$list[] = $tmp;
			}
		}
		return $list;
	}
	
	//index, type, completed,recursive,list
	protected static function getNextLeafNode(&$node) {
		
		if ($node['type']=='leaf') {
			return $node;
		}
		
		if ($node['completed']) {
			return [];
		}
		
		if ($node['type']=='node') {
			if (!$node['recursive']) {
				$cur_index = $node['index'];
				if ($cur_index==count($node['list'])){
					$node['completed'] = true;
					return [];
				}
				$leaf = $node['list'][$cur_index];
				$node['index']++;
				return $leaf;
			} else {
				$index = $node['index'];
				$node['index'] = ($node['index'] + 1) % count($node['list']);
				return self::getNextLeafNode($node['list'][$index]);
			}
		}
			
		
	}
}

/***** Run the Algorithm ****/
$distributed_leaf = TreeKonapazDistribution::getDistributedLeaf($tree);


echo '<pre>';
print_r($distributed_leaf);
echo '</pre>';

?>