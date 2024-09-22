document.addEventListener("DOMContentLoaded", () => {
  const containerRef = document.getElementById("tableContainer");
  const data = {
    attackOrigins: [
      // Your attack origin data here
    ],
    attackTargets: [
      // Your attack target data here
    ],
    attackTypes: [
      // Your attack types data here
    ],
    liveAttacks: [
      // Your live attacks data here
    ],
  };

  const [canScrollLeft, setScrollLeft] = [
    false,
    (val) => {
      canScrollLeft = val;
      updateArrows();
    },
  ];
  const [canScrollRight, setScrollRight] = [
    false,
    (val) => {
      canScrollRight = val;
      updateArrows();
    },
  ];

  const updateArrows = () => {
    document
      .getElementById("scrollLeft")
      .classList.toggle("hidden", !canScrollLeft);
    document
      .getElementById("scrollRight")
      .classList.toggle("hidden", !canScrollRight);
  };

  const updateScrollState = () => {
    setScrollRight(
      containerRef.scrollLeft <
        containerRef.scrollWidth - containerRef.clientWidth
    );
    setScrollLeft(containerRef.scrollLeft > 0);
  };

  const scrollRight = () => {
    containerRef.scrollBy({ left: 300, behavior: "smooth" });
  };

  const scrollLeft = () => {
    containerRef.scrollBy({ left: -300, behavior: "smooth" });
  };

  containerRef.addEventListener("scroll", updateScrollState);

  const createTable = (title, headers, rows) => {
    const tableDiv = document.createElement("div");
    tableDiv.className = "mb-4 col-span-1 h-full overflow-hidden";

    const titleElement = document.createElement("h3");
    titleElement.className =
      "p-1 md:p-2 bg-[#2a5266]/50 rounded-lg mriya-bold text-sm md:text-base";
    titleElement.innerText = title;
    tableDiv.appendChild(titleElement);

    const headerDiv = document.createElement("div");
    headerDiv.className =
      "grid grid-cols-4 gap-2 md:gap-4 text-xs md:text-sm bg-[#2a5266]/10 text-white p-1 md:p-2 rounded-lg shadow-md";
    headers.forEach((header) => {
      const headerElement = document.createElement("div");
      headerElement.className = "font-bold mriya-bold";
      headerElement.innerText = header;
      headerDiv.appendChild(headerElement);
    });
    tableDiv.appendChild(headerDiv);

    const rowsDiv = document.createElement("div");
    rowsDiv.className = "bg-[#2a5266]/10 text-white rounded-lg shadow-md mb-4";
    rows.forEach((row) => {
      const rowDiv = document.createElement("div");
      rowDiv.className =
        "grid grid-cols-4 gap-1 md:gap-4 px-1 md:p-2 text-[10px] md:text-xs text-wrap break-words mriya";
      row.forEach((cell) => {
        const cellDiv = document.createElement("div");
        cellDiv.innerText = cell;
        rowDiv.appendChild(cellDiv);
      });
      rowsDiv.appendChild(rowDiv);
    });
    tableDiv.appendChild(rowsDiv);

    return tableDiv;
  };

  const originsTable = createTable(
    "Attack Origins",
    ["ID", "NAME"],
    data.attackOrigins.map((origin) => [origin.id, origin.name])
  );

  const targetsTable = createTable(
    "Attack Targets",
    ["ID", "NAME"],
    data.attackTargets.map((target) => [target.id, target.name])
  );

  const typesTable = createTable(
    "Attack Types",
    ["ID", "PORT", "TYPE"],
    data.attackTypes.map((type) => [type.id, type.port, type.attacker_type])
  );

  const liveAttacksTable = createTable(
    "Live Attacks",
    [
      "Timestamp",
      "Attacker",
      "Att. IP",
      "Att. Geo",
      "Tar. Geo",
      "Att. Type",
      "Port",
    ],
    data.liveAttacks.map((attack) => [
      attack.timestamp,
      attack.attacker,
      attack.attacker_ip,
      attack.attacker_geo,
      attack.target_geo,
      attack.attacker_type,
      attack.port,
    ])
  );

  containerRef.appendChild(originsTable);
  containerRef.appendChild(targetsTable);
  containerRef.appendChild(typesTable);
  containerRef.appendChild(liveAttacksTable);

  const scrollLeftIcon = lucide.createIcon("move-left");
  const scrollRightIcon = lucide.createIcon("move-right");

  scrollLeftIcon.on("click", scrollLeft);
  scrollLeftIcon.addClass(
    "absolute top-[76%] left-2 transform md:hidden w-6 h-6 text-white bg-[#2a5266]/50 rounded-full p-1.5 cursor-pointer hidden"
  );
  scrollLeftIcon.id = "scrollLeft";
  document.body.appendChild(scrollLeftIcon.node);

  scrollRightIcon.on("click", scrollRight);
  scrollRightIcon.addClass(
    "absolute top-[76%] right-2 transform md:hidden w-6 h-6 text-white bg-[#2a5266]/50 rounded-full p-1.5 cursor-pointer hidden"
  );
  scrollRightIcon.id = "scrollRight";
  document.body.appendChild(scrollRightIcon.node);


  

  updateScrollState();
});
