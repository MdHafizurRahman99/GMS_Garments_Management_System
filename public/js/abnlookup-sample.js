/*------------------------------------------------------------------
	Use web service to lookup details of the ABN
  ------------------------------------------------------------------*/
var fieldIdACN = "TextBoxACN";
var fieldIdEntityName = "TextBoxEntityName";
var fieldIdAbnStatus = "TextBoxAbnStatus";
var fieldIdAbnStatusDate = "TextBoxAbnStatusDate";
var fieldIdBusinessName = "TextBoxBusinessName";
var fieldIdBusinessNameList = "ListBoxBusinessName";
var fieldIdEntityTypeName = "TextBoxEntityTypeName";
var fieldIdEntityTypeCode = "TextBoxEntityTypeCode";
var fieldIdGst = "TextBoxGst";
var fieldIdAddressState = "TextBoxAddressState";
var fieldIdAddressPostcode = "TextBoxAddressPostcode";
var spinnerId = "Spinner";

function abnLookup(fieldId, guidId) {
    // Display the hidden fields
    // document.getElementById("EntityNameLabel").style.display = "block";
    // document.getElementById("TextBoxEntityName").style.display = "block";
    // document.getElementById("AbnStatusLabel").style.display = "block";
    // document.getElementById("TextBoxAbnStatus").style.display = "block";
    // document.getElementById("AddressLabel").style.display = "block";
    // document.getElementById("TextBoxAddressState").style.display = "block";
    // document.getElementById("TextBoxAddressPostcode").style.display = "block";
    // document.getElementById("ButtonHide").style.display = "block";

    var abn = getFieldValue(fieldId);
    var guid = getFieldValue(guidId);

    // Extracting only numbers from the string using regular expression
    var numbers = abn.replace(/\s/g, "");

    if (numbers) {
        // console.log(numbers);
        if (numbers.length == "11") {
            console.log(numbers);
            var jasonScript;
            // var domain = window.location.protocol + "//" + window.location.host;
            var domain = "https://abr.business.gov.au";
            var request =
                domain +
                "/json/AbnDetails.aspx?callback=abnCallback&abn=" +
                abn +
                "&guid=" +
                guid;

            // console.log("ABN");
        } else if (numbers.length == "9") {
            var acn = abn;
            console.log(acn);
            var jasonScript;
            // var domain = window.location.protocol + "//" + window.location.host;
            var domain = "https://abr.business.gov.au";
            var request =
                domain +
                "/json/AcnDetails.aspx?callback=abnCallback&acn=" +
                acn +
                "&guid=" +
                guid;
        }
    } else {
        var jasonScript;
        // var domain = window.location.protocol + "//" + window.location.host;
        var domain = "https://abr.business.gov.au";
        var request =
            domain +
            "/json/AbnDetails.aspx?callback=abnCallback&abn=" +
            abn +
            "&guid=" +
            guid;
    }

    // var jasonScript;
    // // var domain = window.location.protocol + "//" + window.location.host;
    // var domain = "https://abr.business.gov.au";
    // var request =
    //     domain +
    //     "/json/AbnDetails.aspx?callback=abnCallback&abn=" +
    //     abn +
    //     "&guid=" +
    //     guid;
    // console.log(request);
    try {
        // abnInitialise();
        // console.log(request);
        jasonScript = new jsonRequest(request);
        jasonScript.buildScriptTag();
        jasonScript.addScriptTag();
    } catch (exception) {
        alert(exception.Description);
    }
}
/*------------------------------------------------------------------
  Call back function
  ------------------------------------------------------------------ */
function abnCallback(abnData) {
    console.log(abnData);
    setFieldValue(fieldIdACN, abnData.Acn);

    setFieldValue(fieldIdEntityName, abnData.EntityName);
    setFieldValue(fieldIdAbnStatus, abnData.AbnStatus);
    setFieldValue(fieldIdAbnStatusDate, abnData.AbnStatusEffectiveFrom);
    setFieldValue(fieldIdEntityTypeName, abnData.EntityTypeName);
    setFieldValue(fieldIdEntityTypeCode, abnData.EntityTypeCode);
    setFieldValue(fieldIdGst, abnData.Gst);
    setFieldValue(fieldIdAddressPostcode, abnData.AddressPostcode);
    setFieldValue(
        fieldIdAddressState,
        abnData.AddressState + " " + abnData.AddressPostcode
    );

    $('input[name="abn_entity_name"]').val(abnData.EntityName);
    $('input[name="abn_status"]').val(abnData.AbnStatus);
    $('input[name="abn_business_name"]').val(abnData.EntityName);
    $('input[name="abn_address"]').val(
        abnData.AddressState + " " + abnData.AddressPostcode
    );

    const businessNames = abnData.BusinessName;

    // Get the select element by its ID
    const selectElement = document.getElementById("businessNamesSelect");
    // Clear existing options
    selectElement.innerHTML = "";
    // Loop through the business names and create <option> elements
    businessNames.forEach((name) => {
        const option = document.createElement("option");
        option.value = name; // Assuming the name can be used as the value
        option.text = name; // Display the name as the option text
        selectElement.appendChild(option); // Append the option to the select element
    });

    const option = document.createElement("option");
    option.value = abnData.EntityName; // Assuming the name can be used as the value
    option.text = abnData.EntityName; // Display the name as the option text
    selectElement.appendChild(option); // Append the option to the select element
    option.selected = true;
    for (var i = 0; i < abnData.BusinessName.length; i++) {
        addValueToListBox(fieldIdBusinessNameList, abnData.BusinessName[i]);
        if (i == 0) {
            setFieldValue(fieldIdBusinessName, abnData.BusinessName[0]);
        }
    }
    if (abnData.Message.length > 0) {
        setFieldValue(fieldIdEntityName, abnData.Message);
    }
    $("#abn_lookup").modal("show");
    // document.getElementById(spinnerId).style.display = "none";
}
// function acnCallback(abnData) {
//     console.log(abnData);
//     setFieldValue(fieldIdEntityNameABN, abnData.Abn);
//     setFieldValue(fieldIdEntityNameACN, abnData.EntityName);
//     setFieldValue(fieldIdAbnStatusACN, abnData.AbnStatus);
//     setFieldValue(fieldIdAbnStatusACNDate, abnData.AbnStatusEffectiveFrom);
//     setFieldValue(fieldIdEntityTypeNameACN, abnData.EntityTypeName);
//     setFieldValue(fieldIdEntityTypeCodeACN, abnData.EntityTypeCode);
//     setFieldValue(fieldIdGstACN, abnData.Gst);
//     setFieldValue(fieldIdAddressPostcodeACN, abnData.AddressPostcode);
//     setFieldValue(fieldIdAddressStateACN, abnData.AddressState);
//     for (var i = 0; i < abnData.BusinessName.length; i++) {
//         addValueToListBox(fieldIdBusinessNameListACN, abnData.BusinessName[i]);
//         if (i === 0) {
//             setFieldValue(fieldIdBusinessNameACN, abnData.BusinessName[0]);
//         }
//     }
//     if (abnData.Message.length > 0) {
//         setFieldValue(fieldIdEntityNameACN, abnData.Message);
//     }
//     // document.getElementById(spinnerId).style.display = 'none';
// }
/*------------------------------------------------------------------
  Initialise form fields 
  ------------------------------------------------------------------ */
function abnInitialise() {
    setFieldValue(
        fieldIdEntityName,
        "Requesting ABN Lookup data ... please wait"
    );
    setFieldValue(fieldIdACN, "");
    setFieldValue(fieldIdAbnStatus, "");
    setFieldValue(fieldIdAbnStatusDate, "");
    setFieldValue(fieldIdEntityTypeName, "");
    setFieldValue(fieldIdEntityTypeCode, "");
    setFieldValue(fieldIdGst, "not registered");
    setFieldValue(fieldIdAddressPostcode, "");
    setFieldValue(fieldIdAddressState, "");
    setFieldValue(fieldIdBusinessName, "");
    clearListBox(fieldIdBusinessNameList);
    // document.getElementById(spinnerId).style.display = "inline";
}

function hideFields() {
    var fieldsToHide = [
        "EntityNameLabel",
        "TextBoxEntityName",
        "AbnStatusLabel",
        "TextBoxAbnStatus",
        "AddressLabel",
        "TextBoxAddressState",
        "TextBoxAddressPostcode",
        "ButtonHide",
    ];

    fieldsToHide.forEach(function (fieldId) {
        var field = document.getElementById(fieldId);
        if (field && field !== document.getElementById("ButtonHide")) {
            if (field.style.display === "none") {
                // field.style.display = "block"; // Show the hidden fields
            } else {
                field.style.display = "none"; // Hide the fields
            }
        }
    });
    document.getElementById("ButtonHide").style.display = "none";
}
