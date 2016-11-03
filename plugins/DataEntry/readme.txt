Plugin to recopile the data from a web form.
The form can be in a web page or in a web window.

Use:

 It is mandatory use:
    JQuery
    JSLogger


 In the html code:
  <div class="DataEntryContainer">
     <!-- Div where must be the labels and input data -->
     <div class="DataEntryRow"> 
        <!-- Row composes by a label and an input object-->
        <div class="DataEntryLabel" id="label">
           Label:
        </div>
        <div class="DataEntryValue" id="Contact-Label-Value">
           <input type="text">
        </div>
     </div>
     <!-- Repeat the rows -->
  </div>
  <!-- Container where the buttons can be added -->
  <div class="DataEntryButtonsContainer">
     <div class="Round-Corners-Button DataEntryWindowButtonOk" id="Button-Contact">Send</div>
  </div>


For get the values from the form, use the script:
   DataEntryFunctions.getValues(<DataEntryContainer container parent>);
   This function returns a string with in JSON formant with the form data (<label like key>, <data>)

The function clearValues, cleans the html inputs

The style is defined in the file DataEntry.css.
It can be modified to define the style

