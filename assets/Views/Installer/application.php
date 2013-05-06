<p>
The follow information is used throughout the application.
</p>
<table>
<tr><td>Site Name:</td><td><input type='text' name='appName' value='<?php echo $appName; ?>' /></td></tr>
<tr><td>Administrator Nickname:</td><td><input type='text' name='appNickname' value='<?php echo $appNickname; ?>' /></td></tr>
<tr><td>Administrator Email:</td><td><input type='text' name='appEmail' value='<?php echo $appEmail; ?>' /></td></tr>
<tr><td>Administrator Password:</td><td><input type='password' name='appPassword' /></td></tr>
</table>
<hr />
<table>
<tr><td>Allow modifications of your work?</td><td>
<select name='appModification'>
<option value=''>Yes</option>
<option value='-nd'>No</option>
<option value='-sa'>Yes, as long as others share alike</option>
</select>
</td></tr>
<tr><td>Allow commercial uses of your work?</td><td>
<select name='appCommercial'>
<option value=''>Yes</option>
<option value='-nc'>No</option>
</select>
</td></tr>
</table>
