function createCheckboxWithIcon(inputName, value, checked) {
    const container = document.createElement("div");
    container.classList.add("inline-flex", "items-center");

    const label = document.createElement("label");
    label.classList.add("flex", "items-center", "cursor-pointer", "relative");

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.checked = true;
    checkbox.classList.add(
        "peer",
        "h-5",
        "w-5",
        "cursor-pointer",
        "transition-all",
        "appearance-none",
        "rounded",
        "shadow",
        "hover:shadow-md",
        "border",
        "border-gray-300",
        "checked:bg-upbg",
        "checked:border-upbg"
    );
    checkbox.name = inputName;
    checkbox.value = value;
    checkbox.checked = checked;

    const span = document.createElement("span");
    span.classList.add(
        "absolute",
        "text-white",
        "opacity-0",
        "peer-checked:opacity-100",
        "top-1/2",
        "left-1/2",
        "transform",
        "-translate-x-1/2",
        "-translate-y-1/2"
    );

    const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    svg.setAttribute("viewBox", "0 0 20 20");
    svg.setAttribute("fill", "currentColor");
    svg.setAttribute("stroke", "currentColor");
    svg.setAttribute("stroke-width", "1");
    svg.classList.add("h-3.5", "w-3.5");

    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("fill-rule", "evenodd");
    path.setAttribute("d", "M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z");
    path.setAttribute("clip-rule", "evenodd");

    svg.appendChild(path);
    span.appendChild(svg);
    label.appendChild(checkbox);
    label.appendChild(span);
    container.appendChild(label);

    return container;
}