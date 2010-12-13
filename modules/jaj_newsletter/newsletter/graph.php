<?php
		$Module = $Params[ 'Module' ];
		$object_id = $Params['ObjectID'];
		$node = eZContentObject::fetch( $object_id );

		if ( !$node || !$node->canRead() )
			return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

		$db = eZDB::instance();
		$sql = "SELECT COUNT(sent) as Sent, COUNT(opened) as Opened FROM jaj_newsletter_delivery WHERE contentobject_id=" . $node->ID; //, COUNT(viewed) as Viewed
		$data = $db->arrayQuery( $sql );
		$data = $data[0];
		$data['Sent'] -= ($data['Opened']); // + $data['Viewed']
		
		$graph = new ezcGraphPieChart();

		$graph->title = 'Newsletter Activity';
		$graph->legend = false; 

		$graph->data['Newsletter Activity'] = new ezcGraphArrayDataSet( $data );
		$graph->data['Newsletter Activity']->highlight['Opened'] = true;
		//$graph->data['Newsletter Activity']->highlight['Viewed'] = true;
		
		// select count(sent) as sent, count(opened) as opened, count(viewed) as viewed from jaj_newsletter_delivery where contentobject_id=947;
		
		$graph->renderToOutput( 400, 240 ); 
  	 	eZExecution::cleanExit();
  	 	
		//$graph->render( 400, 150, 'tutorial_simple_pie.svg' );
		
		//print_r( $rows );
		
		//select date(FROM_UNIXTIME(modified)) as date, state, count(uuid) as count from jaj_newsletter_subscription group by date,state;
?>