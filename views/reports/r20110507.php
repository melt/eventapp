<?php namespace nmvc; ?>
<div class="global_paddings">
<table class="table_100p">
	<tbody><tr>
	<td class="bontq_logo">
		<img src="<?php echo url("/static/report/print_logo.gif"); ?>" alt="">
	</td>
	<td class="generated"><strong>Generated on:</strong> 05/08/2011</td>
	</tr>
</tbody></table>
    
	<div class="main_container">
		<div class="top_container">
			<div class="title">
				<strong class="text georgia">Report</strong>
			</div>
			<div class="s_results_quantity">
				<strong>11/02/2010 - 05/08/2011</strong>
			</div>
			<div class="cleaner"><!-- --></div>
		</div>
	</div>

	<div class="stats">
		<div class="container"><strong>Companies(1):</strong> Omnicloud</div>
		<div class="container"><strong>Projects(1):</strong> Sandbox Event App</div>
		<div class="container"><strong>Related Users(1):</strong> Per Jonsson</div>
			</div>


	<div class="content_container">
<table class="table_100p
&lt;!--[if IE 6]&gt;
fixed
&lt;![endif]--&gt;
">
	<tbody><tr>
	        <td class="ta_head " style="width: 66px;"><div class="placeholder"></div></td>    <td class="ta_head " style="width:55px"><span>ID</span></td>    <td class="ta_head " style=""><span>Name</span></td>    <td class="ta_head " style="width:98px"><span>Date opened</span></td>    <td class="ta_head " style="width: 65px"><span>Status</span></td>    <td class="ta_head " style="width:66px"><span>Priority</span></td>    <td class="ta_head " style="width:66px"><span>Label</span></td>    <td class="ta_head " style="width:123px"><span>Created by</span></td>    <td class="ta_head last_one" style="width:98px"><span>Date modified</span></td>	</tr>
	<tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#38</span></td><td class="ta_item darkness"><span>User list</span><span class="gray_pv_desc">Ambassador should see users from own hub by default
Should be able to filter on hub</span></td><td class="ta_item"><span>Apr 29, 13:24</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>View</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#56</span></td><td class="ta_item darkness"><span>Facebook Login</span><span class="gray_pv_desc">The system should have a Facebook login feature using the Facebook OAUTH API.

Name, current city and phone number of the user should be fetched from the Facebook profile upon login and then stored in the database.

</span></td><td class="ta_item"><span>May 8, 23:17</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#55</span></td><td class="ta_item darkness"><span>Permission levels for users</span><span class="gray_pv_desc">Administrators will have allow all permissions in the application.

Ambassadors will have allow permissions on features related to the own hub, allow on features related to the user's own profile and deny on all other features.

Members will have allow permissions on features related to the user's own profile and deny on all other features.

Guests will have deny all permissions in the application.
</span></td><td class="ta_item"><span>May 8, 23:14</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Controller</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#29</span></td><td class="ta_item darkness"><span>RVSP Model</span><span class="gray_pv_desc">An event has many RVSPs

States for attending 0 (NOT REPLIED) or 1 (NO) or 2 (YES)

Fields with the relevant info as described on RVSP Page

Volatile boolean for wishes to Skype 0 (NO) or 1 (YES)

Text field for brings a friend to the event if user is member

Tickboxes for reasons why not to attend (time does not fit me, i do not know anyone in sandbox yet, the theme does not fit me, other)</span></td><td class="ta_item"><span>Apr 29, 13:02</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>Model</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#36</span></td><td class="ta_item darkness"><span>Add hub</span><span class="gray_pv_desc">Administrator should be able to add new hubs and attach multiple users to that hub as ambassadors (which would grant them ambassador permissions).

Add hub method should include the fields of the hub model</span></td><td class="ta_item"><span>Apr 29, 13:19</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#27</span></td><td class="ta_item darkness"><span>User model</span><span class="gray_pv_desc">Username is email address
Should include phone number
Should include first name
Should include last name
Should include company/affiliation
Should include hub(s)
Should include current city and country
Should include unsubscribed boolean 0/1 NO/YES</span></td><td class="ta_item"><span>Apr 29, 12:53</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--1 -->Critical</span></td><td class="ta_item"><span>Model</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#33</span></td><td class="ta_item darkness"><span>Event model</span><span class="gray_pv_desc">Title
Venue
Date
Time
Street, City, Number
INVITE_EMAIL_SENT
REMINDER_EMAIL_SENT
THANKYOU_EMAIL_SENT</span></td><td class="ta_item"><span>Apr 29, 13:10</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--1 -->Critical</span></td><td class="ta_item"><span>Model</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#37</span></td><td class="ta_item darkness"><span>Hub model</span><span class="gray_pv_desc">Name of hub
Country from dropdown
One hub has many users (ambassadors)
One hub has many users (members)</span></td><td class="ta_item"><span>Apr 29, 13:20</span></td><td class="ta_item"><span>Closed</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Model</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:41</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#25</span></td><td class="ta_item darkness"><span>Invitation to users</span><span class="gray_pv_desc">Email subject should include name of event, date and venue

Email heading should include name of event

Location and date should be clearly stated

Map should be clearly stated

Email content should include the custom text that user entered when adding the event, if not then just include the standard

Mail should include personally generated invitation link for every user in database, with option to say YES or NO. Either of thems brings user to the RVSP page.

To: &lt;you&gt;
Cc: ambassadors@sandbox-network.com
Bcc: participants’ email addresses
Subject line: Personal Invite to Sandbox Dinner at &lt;place&gt;, &lt;date and time&gt;


Dear (potential) Sandboxers,

I have the pleasure to invite you to our next Sandbox Dinner in &lt;place&gt; (&lt;link to the
restaurant on Google Maps&gt;), which will take place on &lt;date&gt; at &lt;time&gt;.
&lt;Add a teaser (one sentence of the overall topic of the evening, for example “April’s
Fools”, “Summer dinner”; exciting special guests; etc.)&gt;
Please find the bibliographies of the participants below &lt;bibliographies&gt; {and fill out
a &lt;google doc&gt; (optional). }

Please confirm your participation as soon as possible. You will receive a confirmation
email with the name of the location a couple of days beforehand.

Looking forward to seeing you there,

&lt;Your Name&gt;
______
ABOUT SANDBOX
Sandbox is a trusted global community where extraordinary young achievers under 30 come together. It’s an inspiring meeting place where a selection of young thinkers and doers connect, exchange ideas, and get empowered.

We organise events in the major global cities with the ambition to inspire our members with innovative content and challenging discussions. Via our closed online platform, we are connecting Sandboxers all around the world and provide a platform where those people get access to their peers, seniors, jobs, resources, and opportunities. For more information about Sandbox, visit our website: http://www.sandbox-network.com
</span></td><td class="ta_item"><span>Apr 29, 12:43</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--2 -->High</span></td><td class="ta_item"><span>Email</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 12:54</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#26</span></td><td class="ta_item darkness"><span>Pre-invite email to other ambassadors</span><span class="gray_pv_desc">Ambassador should be able to send a pre-invite mail to other ambassadors looking for cool friends to invite

hong kong: sandbox dinner this thursday 20:00 do you have any cool friends in HK that we should invite?</span></td><td class="ta_item"><span>Apr 29, 12:44</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>Email</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 12:44</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#32</span></td><td class="ta_item darkness"><span>Event list</span><span class="gray_pv_desc">Should show all events that have been added
Should show number of attendees of the event
Should show INVITE SENT, REMINDER SENT, THANKYOU SENT states in list
Should be able to click events for details</span></td><td class="ta_item"><span>Apr 29, 13:08</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Email</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:08</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#28</span></td><td class="ta_item darkness"><span>RVSP Page</span><span class="gray_pv_desc">For YES a few fields such as most exciting project, biggest challenge and how they can generally help should be filled in (this helps the seating arrangements and who else to invite). Also the user should be asked if he/she wishes to Skype with ambassador before the event (if possible) "Spend a small amount of time Skyping each guest before a Sandbox event. Understand current challenges and projects of each guest and how it may overlap with other guests. From this you can design effective seating plans."

The form should also start with a "Is this still you"? section where user can update Company/Affiliation and other relevant fields.

I currently live is an important field.

If NO then mail should optionally ask why the person does not wish to attend for reference.</span></td><td class="ta_item"><span>Apr 29, 12:56</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>View</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:25</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#31</span></td><td class="ta_item darkness"><span>Thank you email after dinner</span><span class="gray_pv_desc">Ability to send thankyou email to attendees of dinner.

Should include link to some very simple feedback form.


To: - (or visible email address if you don’t include them below)
Cc: ambassadors@sandbox-network.com
Bcc: participants’ email addresses
Subject line: Thank you for attending the Sandbox Dinner in &lt;place&gt;

Dear (potential) Sandboxers,

Thank you for attending the Sandbox dinner in &lt;place&gt; yesterday! We hope you enjoyed the
food and the conversations and are already looking forward to seeing you at our next event.
Those of you who are not yet admitted to our selective community, please apply here:
http://www.sandbox-network.com/join/.

We will also post some pictures and a blog post on our webpage soon; please don’t hesitate to connect with the participants and others on our closed platform!

Thanks and best wishes,

&lt;your name&gt;</span></td><td class="ta_item"><span>Apr 29, 13:04</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>Email</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:10</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#57</span></td><td class="ta_item darkness"><span>Google Maps on RVSP Page</span><span class="gray_pv_desc">A map of the location of the event should be shown on the RVSP page. The map should be generated using the Google Maps API.</span></td><td class="ta_item"><span>May 8, 23:19</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:26</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#35</span></td><td class="ta_item darkness"><span>API function for displaying events in hub</span><span class="gray_pv_desc">API function should send list of events in hub to Wordpress website including time, date and venue.</span></td><td class="ta_item"><span>Apr 29, 13:16</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--2 -->High</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:16</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#34</span></td><td class="ta_item darkness"><span>Hub Email Extract Function</span><span class="gray_pv_desc">Ambassador should be able to filter member list based on hub and other preferences and then export the email addresses to format that he/she can copy into gmail</span></td><td class="ta_item"><span>Apr 29, 13:13</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--4 -->Low</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:13</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#30</span></td><td class="ta_item darkness"><span>Reminder Invite to Users</span><span class="gray_pv_desc">Ability to send reminder email from Event show page to users that have not yet replied.

To: -
Cc: ambassadors@sandbox-network.com
Bcc: participants’ email addresses
Subject line: Reminder: Sandbox Dinner &lt;location, time&gt;

Dear (potential) Sandboxers,
we are looking forward to seeing you at the next Sandbox dinner at &lt;location, time&gt;.
&lt;add optional “friendly line”/additional information&gt;.

Best wishes,

&lt;your name&gt;</span></td><td class="ta_item"><span>Apr 29, 13:03</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--2 -->High</span></td><td class="ta_item"><span>Email</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 13:03</span></td></tr><tr><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#24</span></td><td class="ta_item darkness"><span>Add Event</span><span class="gray_pv_desc">Should be able to fill in fields from event model

A link to a registration form should be automatically generated
</span></td><td class="ta_item"><span>Apr 29, 12:34</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--2 -->High</span></td><td class="ta_item"><span>Method</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>Apr 29, 12:46</span></td></tr><tr class="ta_bordered"><td class="ta_item"><span><strong class="icon_title">Task</strong></span></td><td class="ta_item"><span>#58</span></td><td class="ta_item darkness"><span>JQuery for Invitation Page</span><span class="gray_pv_desc">The invitation page should have Jquery features to invite users in a simple manner.

The ambassador can filter and search users to invite from a list and then add them to the invitation dynamically.
</span></td><td class="ta_item"><span>May 8, 23:24</span></td><td class="ta_item"><span>Open</span></td><td class="ta_item"><span><!--3 -->Medium</span></td><td class="ta_item"><span>View</span></td><td class="ta_item"><span>Per Jonsson</span></td><td class="ta_item last"><span>May 8, 23:27</span></td></tr></tbody></table>
	</div>


</div>
