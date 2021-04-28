import React, {useState} from 'react';
import { Link} from 'react-router-dom';
function Navbar() {
    return (
        <>
           <nav className="navbar">
               <div className="navbar-container">
                   <Link to="/" className="navbar-logo">Online-Broker<i className='fas fa-chart-line'/></Link>
               </div>
           </nav>

        </>
    )
}

export default Navbar
