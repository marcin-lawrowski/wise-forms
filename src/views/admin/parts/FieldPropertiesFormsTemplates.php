<!-- Field Properties Forms: -->
<script id="textInputTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="label">Label: </label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="label" type="text" name="label" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="labelWidth">Label width: </label></td>
				<td><input type="text" id="labelWidth" name="labelWidth" style="width: 70px" placeholder="auto" />&nbsp;px</td>
			</tr>
			<tr>
				<td><label>Label location: </label></td>
				<td><label><input type="radio" name="labelLocation" value="top" />Top</label>&nbsp;&nbsp;<label><input type="radio" name="labelLocation" value="inline" />Inline</label></td>
			</tr>
			<tr>
				<td><label for="labelAlign">Label align: </label></td>
				<td><select id="labelAlign" name="labelAlign"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td>
			</tr>
			<tr>
				<td colspan="2"><label for="placeholder">Placeholder:</label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="placeholder" type="text" name="placeholder" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="required">Required: </label></td>
				<td><input id="required" type="checkbox" name="required" /></td>
			</tr>
			<tr>
				<td><label for="width">Width: </label></td>
				<td><select id="width" name="width"><option value="auto">Auto</option><option value="100%">100%</option></select></td>
			</tr>
		</table>
	</div>
</script>

<script id="textAreaTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="label">Label: </label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="label" type="text" name="label" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="labelWidth">Label width: </label></td>
				<td><input type="text" id="labelWidth" name="labelWidth" style="width: 70px" placeholder="auto" />&nbsp;px</td>
			</tr>
			<tr>
				<td><label>Label location: </label></td>
				<td><label><input type="radio" name="labelLocation" value="top" />Top</label>&nbsp;&nbsp;<label><input type="radio" name="labelLocation" value="inline" />Inline</label></td>
			</tr>
			<tr>
				<td><label for="labelAlign">Label align: </label></td>
				<td><select id="labelAlign" name="labelAlign"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td>
			</tr>
			<tr>
				<td colspan="2"><label for="placeholder">Placeholder:</label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="placeholder" type="text" name="placeholder" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="required">Required: </label></td>
				<td><input id="required" type="checkbox" name="required" /></td>
			</tr>
			<tr>
				<td><label for="width">Width: </label></td>
				<td><select id="width" name="width"><option value="auto">Auto</option><option value="100%">100%</option></select></td>
			</tr>
			<tr>
				<td><label for="height">Height: </label></td>
				<td><input type="text" id="height" name="height" style="width: 70px" placeholder="auto" />&nbsp;px</td>
			</tr>
		</table>
	</div>
</script>

<script id="paragraphTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="text">Text: </label></td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="text" name="text" class="wfFullWidth"></textarea></td>
			</tr>
		</table>
	</div>
</script>

<script id="buttonSubmitTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="label">Label: </label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="label" type="text" name="label" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="align">Align: </label></td>
				<td><select id="align" name="align"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td>
			</tr>
		</table>
	</div>
</script>

<script id="dropDownListTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="label">Label: </label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="label" type="text" name="label" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="labelWidth">Label width: </label></td>
				<td><input type="text" id="labelWidth" name="labelWidth" style="width: 70px" placeholder="auto" />&nbsp;px</td>
			</tr>
			<tr>
				<td><label>Label location: </label></td>
				<td><label><input type="radio" name="labelLocation" value="top" />Top</label>&nbsp;&nbsp;<label><input type="radio" name="labelLocation" value="inline" />Inline</label></td>
			</tr>
			<tr>
				<td><label for="labelAlign">Label align: </label></td>
				<td><select id="labelAlign" name="labelAlign"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td>
			</tr>
			<tr>
				<td colspan="2"><label for="placeholder">Placeholder:</label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="placeholder" type="text" name="placeholder" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="required">Required: </label></td>
				<td><input id="required" type="checkbox" name="required" /></td>
			</tr>
			<tr>
				<td><label for="width">Width: </label></td>
				<td><select id="width" name="width"><option value="auto">Auto</option><option value="100%">100%</option></select></td>
			</tr>
			<tr>
				<td colspan="2"><label for="options">Options:</label></td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="options" name="options" class="wfFullWidth"></textarea></td>
			</tr>
		</table>
	</div>
</script>

<script id="checkboxesTemplateProperties" type="text/template">
	<div>
		<table>
			<tr>
				<td colspan="2"><label for="label">Label: </label></td>
			</tr>
			<tr>
				<td colspan="2"><input id="label" type="text" name="label" class="wfFullWidth" /></td>
			</tr>
			<tr>
				<td><label for="labelWidth">Label width: </label></td>
				<td><input type="text" id="labelWidth" name="labelWidth" style="width: 70px" placeholder="auto" />&nbsp;px</td>
			</tr>
			<tr>
				<td><label>Label location: </label></td>
				<td><label><input type="radio" name="labelLocation" value="top" />Top</label>&nbsp;&nbsp;<label><input type="radio" name="labelLocation" value="inline" />Inline</label></td>
			</tr>
			<tr>
				<td><label for="labelAlign">Label align: </label></td>
				<td><select id="labelAlign" name="labelAlign"><option value="left">Left</option><option value="center">Center</option><option value="right">Right</option></select></td>
			</tr>
			<tr>
				<td><label for="required">Required: </label></td>
				<td><input id="required" type="checkbox" name="required" /></td>
			</tr>
			<tr>
				<td colspan="2"><label for="options">Options:</label></td>
			</tr>
			<tr>
				<td colspan="2"><textarea id="options" name="options" class="wfFullWidth"></textarea></td>
			</tr>
		</table>
	</div>
</script>