import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Routes, Route } from "react-router-dom";

import Login from "./Login";
import Register from "./Register";
import Referrals from "./Referrals";
import Admin from "./Admin";

function App() {
    return (
        <>
        <Routes>
            <Route path="/" element={<Login /> } />
            <Route path="/login" element={<Login /> } />
            <Route path="/register" element={<Register /> } />
            <Route path="/referrals" element={<Referrals /> } />
            <Route path="/admin/referrals" element={<Admin /> } />
        </Routes>
        </>
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(
        <BrowserRouter>
            <App />
        </BrowserRouter>
            , document.getElementById('app'));
}