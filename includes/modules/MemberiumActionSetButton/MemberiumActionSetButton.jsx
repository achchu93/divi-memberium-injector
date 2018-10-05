// External Dependencies
import React, { Component, Fragment } from 'react';

// Internal Dependencies
import './style.css';


class MemberiumActionSetButton extends Component {

    static slug = 'dmi_button';

    render() {
        return (
            <Fragment>
                <h1 className="dmi_button">{this.props.heading}</h1>
                <p>
                    {this.props.content()}
                </p>
            </Fragment>
        );
    }
}

export default MemberiumActionSetButton;