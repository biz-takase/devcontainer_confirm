import { createRoot } from "react-dom/client";
import App from "./App";

const container = document.getElementById("root");
// createRootでrootエレメント がnullの場合を考慮する
if (!container) throw new Error("failed to find the root element");
const root = createRoot(container);

root.render(<App str={"param"} num={777} />);
