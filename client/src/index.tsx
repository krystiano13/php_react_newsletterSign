import { createRoot } from "react-dom/client";
import { App } from "./App";

const rootDiv: HTMLElement = document.querySelector("#root") as HTMLElement;
const root = createRoot(rootDiv);

import './styles/index.css';

root.render(
  <>
    <App />
  </>
);
