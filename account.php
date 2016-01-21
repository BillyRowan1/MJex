<?php include 'header.php'; ?>
<section id="Account" class="container">

	<div class="row">
		<div class="col-md-12">
			<!-- Nav tabs -->
		    <ul class="nav nav-tabs" role="tablist">
		        <li role="presentation"><a href="#tab-orders" aria-controls="home" role="tab" data-toggle="tab">Ads and Orders</a></li>
		        <li role="presentation" class="active"><a href="#tab-chat-history" aria-controls="profile" role="tab" data-toggle="tab">Chat history</a></li>
		        <li role="presentation"><a href="#tab-contact" aria-controls="messages" role="tab" data-toggle="tab">Contact info</a></li>
		    </ul>
		    <!-- Tab panes -->
		    <div class="tab-content">
		        <div role="tabpanel" class="tab-pane" id="tab-orders">
		        	<div class="form-group">
		        		<label for="filter_1">Medical</label>
		        		<input type="checkbox" name="medical">
		        		<label for="filter_2">Adult use</label>
		        		<input type="checkbox" id="filter_2" name="medical">
		        		<label for="filter_3">Both</label>
		        		<input type="checkbox" id="filter_3" name="medical">
		        	</div>

		        	<table class="table">
		        		<thead>
		        			<th>#</th>
		        			<th>DATE</th>
		        			<th>description</th>
		        			<th>price / unit</th>
		        			<th>sold</th>
		        			<th>repost</th>
		        			<th>delete</th>
		        			<th>edit</th>
		        		</thead>
		        		<tbody>
		        			<tr>
		        				<td>005</td>
		        				<td>12/24/2015</td>
		        				<td>sativa</td>
		        				<td>20 usd</td>
		        				<td>0</td>
		        				<td><img src="img/ic-repost.png" alt="" class="repost"></td>
		        				<td><img src="img/ic-delete.png"></td>
		        				<td><img src="img/ic-edit.png"></td>
		        			</tr>
		        		</tbody>
		        	</table>
		        </div>
		        <div role="tabpanel" class="tab-pane active" id="tab-chat-history">
		        	<div class="row">
			        	<div class="col-md-4">
			        		<div class="users box">
				        		<h3 class="title">users</h3>
				        		<ul class="nicescroll">
				        			<li><span class="date">12/04/15</span> w54w5r@mfex.com</li>
				        			<li class="active"><span class="date">12/04/15</span> w54w5r@mfex.com</li>
				        			<li><span class="date">12/04/15</span> w54w5r@mfex.com</li>
				        			<li><span class="date">12/04/15</span> w54w5r@mfex.com</li>
				        		</ul>
			        		</div>
			        	</div>
			        	<div class="col-md-8">
			        		<div class="box chats">
				        		<h3 class="title">chats</h3>
				        		<ul class="nicescroll">
				        			<li class="me">
				        				<span class="name">You</span>
				        				<div class="message">
				        					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit dolorum fuga vel illo, aliquid eum labore. Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:03 pm</span>
				        				</div>
				        			</li>
				        			<li>
				        				<span class="name">8gg7tfff</span>
				        				<div class="message">
				        					Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:05 pm</span>
				        				</div>
				        			</li>
				        			<li>
				        				<span class="name">8gg7tfff</span>
				        				<div class="message">
				        					Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:05 pm</span>
				        				</div>
				        			</li>
				        			<li>
				        				<span class="name">8gg7tfff</span>
				        				<div class="message">
				        					Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:05 pm</span>
				        				</div>
				        			</li>
				        			<li>
				        				<span class="name">8gg7tfff</span>
				        				<div class="message">
				        					Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:05 pm</span>
				        				</div>
				        			</li>
				        			<li class="me">
				        				<span class="name">You</span>
				        				<div class="message">
				        					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit dolorum fuga vel illo, aliquid eum labore. Officiis, sit, hic excepturi eos repudiandae laborum, odit consequatur ratione rerum fugiat soluta deleniti.
				        					<span class="time">2:03 pm</span>
				        				</div>
				        			</li>
				        		</ul>
			        		</div>
			        	</div>
		        	</div>
		        </div>
		        <div role="tabpanel" class="tab-pane" id="tab-contact">...</div>
		    </div>	
		</div>
	</div>

</section>
<?php include 'footer.php'; ?>