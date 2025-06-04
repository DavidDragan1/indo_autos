<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2>Users List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Role Id</th>
		<th>Title</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Password</th>
		<th>Contact</th>
		<th>Dob</th>
		<th>Add Line1</th>
		<th>Add Line2</th>
		<th>City</th>
		<th>State</th>
		<th>Postcode</th>
		<th>Country Id</th>
		<th>Created</th>
		<th>Last Access</th>
		<th>Profile Photo</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($users_data as $users)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $users->role_id ?></td>
		      <td><?php echo $users->title ?></td>
		      <td><?php echo $users->first_name ?></td>
		      <td><?php echo $users->last_name ?></td>
		      <td><?php echo $users->email ?></td>
		      <td><?php echo $users->password ?></td>
		      <td><?php echo $users->contact ?></td>
		      <td><?php echo $users->dob ?></td>
		      <td><?php echo $users->add_line1 ?></td>
		      <td><?php echo $users->add_line2 ?></td>
		      <td><?php echo $users->city ?></td>
		      <td><?php echo $users->state ?></td>
		      <td><?php echo $users->postcode ?></td>
		      <td><?php echo $users->country_id ?></td>
		      <td><?php echo $users->created ?></td>
		      <td><?php echo $users->last_access ?></td>
		      <td><?php echo $users->profile_photo ?></td>
		      <td><?php echo $users->status ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>