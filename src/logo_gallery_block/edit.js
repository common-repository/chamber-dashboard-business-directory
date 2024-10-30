import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { SelectControl, 
    Toolbar,
    Button,
    Tooltip,
    PanelBody,
    PanelRow,
    FormToggle,
    ToggleControl,
    ToolbarGroup,
    Disabled, 
    RadioControl,
    RangeControl,
    FontSizePicker } from '@wordpress/components';

    import {
        RichText,
        AlignmentToolbar,
        BlockControls,
        BlockAlignmentToolbar,
        InspectorControls,
        InnerBlocks,
        withColors,
        PanelColorSettings,
        getColorClassName
    } from '@wordpress/editor'
    ;
import { withSelect, widthDispatch } from '@wordpress/data';


const {
    withState
} = wp.compose;

const formatOptions = [
    { label: 'List', value: 'list' },
    { label: '2 Columns', value: 'grid2' },
    { label: '3 Columns', value: 'grid3' },
    { label: '4 Columns', value: 'grid4' },
    { label: 'Responsive', value: 'responsive' },
 ];

const orderbyOptions = [
    { label: 'Title', value: 'title' },
    { label: 'Date', value: 'date' },
    { label: 'Menu Order', value: 'menu_order' },
    { label: 'Random', value: 'rand' },
 ];

const orderOptions = [
    { label: 'Ascending', value: 'asc' },
    { label: 'Descending', value: 'desc' },
];

const imageSizeOptions = [
    { label: 'Auto', value: '' },
    { label: 'Small', value: 'thumbnail' },
    { label: 'Medium', value: 'medium' },
    { label: 'Large', value: 'large' },
    { label: 'Full Width', value: 'full' },
];
const categoryOptions = [
    { label: 'Select one or more categories', value: null }
];

wp.apiFetch({path: "/wp/v2/business_category?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        categoryOptions.push({label: val.name, value: val.slug});
    });
}).catch( 

)

const membershipLevelOptions = [
    { label: 'Select one or more Membersihp Levels', value: null }
];

const membershipStatusOptions = [
    //{ label: 'Select a Membership Status', value: null }
];

var fetchUrlAction = wpAjax.wpurl+'/wp-admin/admin-ajax.php?action=cdash_check_mm_active_action';


wp.apiFetch({url: fetchUrlAction}).then(response => {
    if(response.cdash_mm_active){
        wp.apiFetch({path: "/wp/v2/membership_status?per_page=100"}).then(posts => {
            jQuery.each( posts, function( key, val ) {
                membershipStatusOptions.push({label: val.name, value: val.slug});
            });
        });
    }
});

wp.apiFetch({path: "/wp/v2/membership_level?per_page=100"}).then(posts => {
    jQuery.each( posts, function( key, val ) {
        membershipLevelOptions.push({label: val.name, value: val.slug});
    });
});

const edit = props => {
    const {attributes: {cd_block, postLayout, format, categoryArray, category, tags, membershipLevelArray, level, displayPostContent, display, text, singleLinkToggle, single_link, perpage, orderby, order, image, membershipStatusArray, status, image_size, alpha, logo_gallery, categoryFilterToggle,  show_category_filter, titleFontSize, disablePagination, }, className, setAttributes } = props;
    const setDirectoryLayout = format => {
        props.setAttributes( { format } );
    };
    
    const setCategories = categoryArray => {
        props.setAttributes( { categoryArray} );
        console.log(categoryArray);
    };
    
    const setMembershipLevel = membershipLevelArray => {
        props.setAttributes( { membershipLevelArray} );
    };
    
    const setMembershipStatus = membershipStatusArray => {
        props.setAttributes( { membershipStatusArray} );
    };
    
    const setSingleLink = singleLinkToggle =>{
        props.setAttributes({singleLinkToggle})
        !! singleLinkToggle ? __( props.setAttributes({single_link: 'yes'}) ) : __( props.setAttributes({single_link: 'no'}) );
        
    };
    
    const inspectorControls = (
        <InspectorControls key="inspector">
            <PanelBody title={ __( 'Formatting Options' )}>
                <PanelRow>
                    <SelectControl
                        label="Directory Layout"
                        value={ format }
                        options= { formatOptions }
                        /*onChange={ ( nextValue ) =>
                            setAttributes( { format:  nextValue } )
                        }*/
                        onChange = {setDirectoryLayout}
                    />
                </PanelRow> 
                <PanelRow>
                    <SelectControl
                        label="Order By"
                        value={orderby}
                        options= { orderbyOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {orderby:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Order"
                        value={order}
                        options= { orderOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( {order:  nextValue } )
                        }
                    />
                </PanelRow>
                <PanelRow>
                    <ToggleControl
						label={ __( 'Enable click-thru to individual listing' ) }
						checked={ singleLinkToggle }
                        onChange = {setSingleLink}
					/>
                </PanelRow>
                <PanelRow>
                    <SelectControl
                        label="Image Size"
                        value={image_size}
                        options= { imageSizeOptions }
                        onChange={ ( nextValue ) =>
                            setAttributes( { image_size:  nextValue } )
                        }
                    />
                </PanelRow>
            </PanelBody>
            <PanelBody title={ __( 'Limit By:' )} initialOpen={ false }>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Categories"
                        value = {categoryArray}
                        options = {categoryOptions}
                        onChange = {setCategories}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Membership Level"
                        value = {membershipLevelArray}
                        options = {membershipLevelOptions}
                        onChange = {setMembershipLevel}
                    />
                </PanelRow>
                <PanelRow>
                    <SelectControl 
                        multiple
                        className = "cdash_multi_select"
                        label = "Membership Status"
                        value = {membershipStatusArray}
                        options = {membershipStatusOptions}
                        onChange = {setMembershipStatus}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    );
    return [
        <div className={ props.className }>
            <ServerSideRender
                block="cdash-bd-blocks/logo-gallery"
                attributes = {props.attributes}
            />
            { inspectorControls }
            <div className="businesslist">
                
            </div>
        </div>
    ];
};

export default edit;