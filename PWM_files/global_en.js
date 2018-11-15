/*********************************************************************************
*
*   This file is part of PHP Web Manager.
*   Copyright (c) 2010-2011 SimpleGeek. All rights reserved.
*   http://www.simplegeek.fr/
* 
*   PHP Web Manager is free software; you can redistribute it and/or
*   modify it under the terms of the GNU General Public License
*   as published by the Free Software Foundation; either version 2
*   of the License, or (at your option) any later version.
* 
*   PHP Web Manager is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
* 
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*  
**********************************************************************************/


/**
* PHP Web Manager: Reloaded
* Fichier: global_en.js
* Dernière modification: 10/06/2010
* Copyright (C) SimpleGeek 2010-2011
**/ 

// Pour les fainéants
function gid(id) { 
	return document.getElementById(id);
}

// Securité
function basename (path) { 
	return path.replace( /.*\//, '' );
}

// Ouverture d'une popup
function newWin(src,h,w,other) {

var H = (screen.height - h) / 3;
var W = (screen.width - w) / 2;
var New = window.open(src,"newWin"+h+w,"width="+w+",height="+h+",fullscreen=no,status=no,toolbar=no,menubar=no,location=no,top="+H+",left="+W+other);

New.focus();
}

// Nouveau Fichier | Dossier
function newfile(type) {

if(type) // Fichier
	var filename = prompt("Enter the new file name to create : ","New File.txt");
else // Dossier
	var filename = prompt("Enter the new folder name to create : ","New Folder");

if(filename != null && filename != "")
	window.location = "?type=newfile&wt="+type+"&name="+filename+"&root="+root;

return false;
}

// Nouveau nom 
function rename(filename,type) {

var newname = (type) ? prompt("New filename \""+filename+"\" ?",filename) : prompt("New folder name \""+filename+"\" ?",filename);

if(newname != filename && newname != null && newname != "" && newname != false)
	window.location = "?type=rename&fp="+root+"/"+filename+"&newname="+newname;

return;
}

// Nouveau nom (recherche)
function newrename(filepath,filename,type) {

var newname = (type) ? prompt("New filename \""+filename+"\" ?",filename) : prompt("New folder name \""+filename+"\" ?",filename);

if(newname != filename && newname != null && newname != "" && newname != false)
	window.location = "?type=rename&fp="+filepath+"&newname="+newname;

return;
}

// Suppression d'un Fichier | Dossier
function unlink(filename,type) {

var confirms = false;

var confirms = (type) ? confirm("Do you really want to delete this file : \""+filename+"\" ?") : confirm("Do you really want to delete this folder : \""+filename+"\" ?");
if(confirms)
	window.location = "?type=unlink&fp="+root+"/"+filename;

return;
}

// Suppression d'un Fichier | Dossier (recherche)
function remove(filepath,filename,type) {

var confirms = false;

var confirms = (type) ? confirm("Do you really want to delete this file : \""+filename+"\" ?") : confirm("Do you really want to delete this folder : \""+filename+"\" ?");
if(confirms)
	window.location = "?type=unlink&fp="+filepath;
return;
}

// Hide / Show
	function hide(arg) {
		var getit = document.getElementById(arg);
		if(getit.style.display=='') {
			getit.style.display = 'none';
		}
		else if(getit.style.display=='none') {
			getit.style.display = '';
		}
}

// Skip image
	function skimg(arg) {
		if(/plus\.gif$/.test(arg.src))
			arg.src = './PWM_files/images/actions/minus.gif';
		else
			arg.src = './PWM_files/images/actions/plus.gif';
}

// Switch le Menu
function toggleOpt() {	if(!menu) { showOpt() }	else { hideOpt() }	}


// Cache le menu
function hideOpt() {
opt.style.visibility = 'hidden';
opt.className = "hide"; // a:hover masqué

menu = false;
	
return;
}

// Affiche le menu
function showOpt() {

opt.style.visibility = 'visible';
opt.className = "visi"; // a:hover visible
	
menu = true;

return;
}

function setCheck(X) {

var lines = []; // array
var Lines = act.getElementsByTagName("input") ; // all inputs

for(i = 0;i < Lines.length; i++ ) // Si I est inférieur au nombre d'input, i++
{ 
	if(Lines[i].name == "actbox[]") // Si actbox
		lines.push(Lines[i]); // On l'a dans l'array :)
}

// N'EST PAS UNE ID
if(isNaN(X))
	{
	count = 0;
	for(i=0;i<lines.length;i++)
		{
		if(X == "r") //reverse
			lines[i].checked = !lines[i].checked;
		if(X == "a") //all
			lines[i].checked = true;
		if(X == "n") //none
			lines[i].checked = false;

		if(lines[i].checked)
			{
			count++;
			gid("td"+ lines[i].id.substr(2) ).className = "checked";
			}
		else
			{
			gid("td"+ lines[i].id.substr(2) ).className = "notchecked";
			}
		}

	if(count > 0 && !menu)
		showOpt();
	else if(count == 0 && menu)
		hideOpt();
	}
// À LA DEMANDE ONCLICK
else if(!ntc) // ntc == false
	{
	 gid("ch"+X).checked = !gid("ch"+X).checked; // Si checker on uncheck & inverse

	if(gid("ch"+X).checked) // Si checker
		{
		gid("td"+X).className = "checked";
		count++;
		// refaire l'array

		}
	else // Sinon
		{
		gid("td"+X).className = "notchecked";
		count--;
		}

	ntc = false;
	}

mReset();
return;
}

// Suppression de la sélection			
	function delete4select() {
		var ask = (count == 1) ? "Do you really want to delete this element ?" : "Do you really want to delete the "+count+" selected elements ?";
		if(count == 0)
			alert("No file selected !");

		else
			if(confirm(ask))
				{
				newType.value = "delete4select";
				act.submit();
				}
		mReset();
	}
	
	function load(src,src2) {
		var H = (screen.height - 200) / 2;
		var W = (screen.width - 500) / 2;
		window.open('?type=player&src='+src+'&src2='+src2, 'son','width=500,height=200,fullscreen=no,scrollbars=no,resizable=no,status=no,toolbar=no,menubar=no,location=no,top='+H+', left='+W);
	}
	
// Calcul chmod	
function octalchange() {

var calc = document.forms["chmod"].getElementsByTagName("input");
var total1=0,total2=0,total3=0,total = 0;

for(i=0;i<calc.length;i++)
	{
	if(calc[i].checked && i <= 2) // 0, 1 et 2
		total1 += Number(calc[i].value);
	if(calc[i].checked && i > 2 && i <= 5) // 3, 4  et 5
		total2 += Number(calc[i].value);
	if(calc[i].checked && i > 5 && i <= 8 ) // 6, 7 et 8
		total3 += Number(calc[i].value);
	}

gid("val").value = (0 + "" +total1 + "" + total2 + "" + total3);
}

// Affiche le Chmod Editor
function chmod() {

if(count == 0) {
	alert("No file selected !");
	return ;
	}

gid("octal").style.display = "block";
gid("listing").style.opacity = 0.3;

return ;
}

// Zip une sélection de fichiers
function zip4select() {
if(count == 0)
	alert("No file selected !");

else
if(bool = prompt("Enter the new archive ZIP name to create: ","New Archive.zip"))
	{
	More.value = "Compressing...";
	newType.value = "zip4select";
	other.value = bool;
	act.submit();
	}
else mReset();
}

// Liste un fichier zip
function list(fp) {
	newWin('?type=listzip&zip='+fp,420,750,',scrollbars=yes,resizable=yes');
}

// Confirmation extraction
function extract(fp) {

if(confirm("Do you really want to extract this archive: \""+basename(fp)+"\" on this folder ?"))
	{
	More.value = "Decompressing...";
	window.location = "?type=extract&fp="+fp;
	}
return;
}