import React from "react";
import "./styles/App.css";

import { Form, Field } from "react-final-form";

const App = () => {
  const submit = async (values: Record<string, any>) => {
    const data = new FormData();
    data.append("email", values.email);
    await fetch("http://localhost/news/server/send.php", {
      method: "post",
      mode: "cors",
      body: data,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.msg === "success") {
          setOperationStatus("done");
        } else {
          setOperationStatus("failed");

          if (data.msg === "free") {
            setOnList(true);
          }
        }
      })
      .catch(err => console.log(err))
  };
  const [operationStatus, setOperationStatus] =
    React.useState<string>("undone");
  const [onList, setOnList] = React.useState<boolean>(false);
  return (
    <main className="App">
      <div className="formContainer">
        {operationStatus === "undone" && (
          <Form
            render={({ handleSubmit }) => (
              <form className="form" onSubmit={handleSubmit}>
                <p className="subtitle">Get Started</p>
                <h1>Enter your e-mail address and get started for free</h1>
                <div className="inputContainer">
                  <Field
                    name="email"
                    render={({ input }) => (
                      <input
                        className="input"
                        type="email"
                        placeholder="Your e-mail address"
                        {...input}
                      />
                    )}
                  />
                  <button type="submit" className="button">
                    Get Started
                  </button>
                </div>
              </form>
            )}
            onSubmit={submit}
          />
        )}
        {operationStatus !== "undone" && (
          <div className="form">
            <h1>
              {operationStatus === "done"
                ? "Your email was added successfuly !!!"
                : `Adding your email failed. ${
                    onList ? "Your address is already on list" : ""
                  }`}
            </h1>
            <button
              onClick={() => {
                setOnList(false);
                setOperationStatus("undone");
              }}
              className="button"
            >
              {operationStatus === "done" ? "Go Homepage" : "Try Again"}
            </button>
          </div>
        )}
        <section className="Background">
          <div className="ball" />
          <div className="stripe"></div>
        </section>
      </div>
    </main>
  );
};

export { App };
