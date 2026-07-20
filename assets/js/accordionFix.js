// Select all Stackable accordion blocks that are currently using DIV instead of DETAILS
const accordions = document.querySelectorAll('div.wp-block-stackable-accordion');

accordions.forEach(divParent => {
  // Check if it contains a summary heading
  const summary = divParent.querySelector('.stk-block-accordion__heading');
  if (!summary) return;

  // Create a new <details> element
  const details = document.createElement('details');
  
  // Copy all attributes (including classes and data-attributes) from the original div
  for (const attr of divParent.attributes) {
    details.setAttribute(attr.name, attr.value);
  }

  // Move all child elements (summary, content, styles) from the <div> to the <details>
  while (divParent.firstChild) {
    details.appendChild(divParent.firstChild);
  }

  // Replace the <div> in the DOM with the new <details> element
  divParent.parentNode.replaceChild(details, divParent);
});
